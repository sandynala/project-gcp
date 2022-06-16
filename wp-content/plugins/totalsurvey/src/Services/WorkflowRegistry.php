<?php


namespace TotalSurvey\Services;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\WorkflowEventDefinition;
use TotalSurvey\Models\WorkflowRule;
use TotalSurvey\Models\WorkflowTaskDefinition;
use TotalSurvey\Plugin;
use TotalSurvey\Tasks\Workflow\AbstractWorkflowTask;
use TotalSurvey\Tasks\Workflow\ProcessSurveyWorkflow;
use TotalSurveyVendors\TotalSuite\Foundation\Event;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Concerns\ResolveFromContainer;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

class WorkflowRegistry
{
    use ResolveFromContainer;

    /**
     * @var Collection<WorkflowEventDefinition>|WorkflowEventDefinition[]
     */
    protected $events;

    /**
     * @var Collection<WorkflowTaskDefinition>|WorkflowTaskDefinition[]
     */
    protected $tasks;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->events = Collection::create();
        $this->tasks  = Collection::create();
    }

    /**
     * @param string       $id
     * @param string       $label
     * @param Event|string $event
     *
     * @throws Exception
     */
    public function registerEvent(string $id, string $label, string $event)
    {
        Exception::throwUnless(
            is_a($event, Event::class, true),
            'The workflow event class should extend Event class.'
        );

        $workflowEvent = new WorkflowEventDefinition(
            [
                'id'    => $id,
                'class' => $event,
                'label' => $label,
            ]
        );

        $this->events->set($id, $workflowEvent);

        Plugin::listen(
            $event,
            static function (Event $event) use ($workflowEvent) {
                ProcessSurveyWorkflow::invoke($event, $workflowEvent);
            }
        );
    }

    /**
     * @param string                      $id
     * @param string                      $label
     * @param AbstractWorkflowTask|string $task
     *
     * @throws Exception
     */
    public function registerTask(string $id, string $label, string $task)
    {
        Exception::throwUnless(
            is_a($task, AbstractWorkflowTask::class, true),
            'The workflow task class should extend AbstractWorkflowTask class.'
        );

        $taskDefinition = new WorkflowTaskDefinition(
            [
                'id'    => $id,
                'class' => $task,
                'label' => $label,
            ]
        );

        $this->tasks->set($id, $taskDefinition);
    }

    /**
     * @return Collection
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * @return Collection
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * @param WorkflowRule $rule
     * @param Event        $event
     *
     * @throws Exception
     */
    public function invokeTaskFromRuleContext(WorkflowRule $rule, Event $event)
    {
        if ($this->tasks->has($rule->task->id)) {
            $this->tasks[$rule->task->id]->class::invoke($rule, $event);
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'events' => $this->events->values(),
            'tasks'  => $this->tasks->values(),
        ];
    }
}