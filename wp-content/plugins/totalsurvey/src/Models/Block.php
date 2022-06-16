<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Services\BlockRegistry;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;

/**
 * Class Block
 *
 * @package TotalSurvey\Models
 *
 * @property string $uid
 * @property string $label
 * @property string $title
 * @property string $category
 * @property string $typeId
 * @property FieldDefinition $field
 * @property array $content
 */
class Block extends Model
{
    /**
     * Types
     */
    const CATEGORY_QUESTION = 'question';
    const TYPE_CONTENT      = 'content';

    /**
     * @var Section
     */
    public $section;

    /**
     * Cast.
     *
     * @var string[]
     */
    protected $types = [
        'field' => 'field',
        'content' => 'array',
    ];

    /**
     * @var \TotalSurvey\Blocks\BlockType
     */
    public $blockType;

    /**
     * Constructor.
     *
     * @param  Section  $section
     * @param  array  $attributes
     */
    public function __construct(Section $section = null, $attributes = [])
    {
        $attributes['category'] = $attributes['category'] ?? (empty($attributes['type']) ? Block::CATEGORY_QUESTION : $attributes['type']);
        $attributes['title']    = $attributes['title'] ?? $attributes['label'] ?? '';
        unset($attributes['type'], $attributes['label']);

        $this->section = $section;
        parent::__construct($attributes);

        $blockCategory = $this->getAttribute('category', $this->getAttribute('type', self::CATEGORY_QUESTION));
        $type          = $this->getAttribute('content.type', $this->getAttribute('field.type'));
        $this->typeId  = $attributes['typeId'] ?? "$blockCategory:$type";


        $this->blockType = BlockRegistry::blockTypeFrom($this->typeId, null) ?? BlockRegistry::blockTypeFrom(
                $type,
                null
            );
        if ($this->blockType) {
            $this->typeId = $this->blockType::getTypeId();
        }

        if ($this->field && $this->field->uid) {
            $this->setAttribute('uid', $this->field->uid);
        }
    }

    /**
     * @param  array  $data
     *
     * @return FieldDefinition
     */
    public function castToField(array $data): FieldDefinition
    {
        return new FieldDefinition($this, $data);
    }

    /**
     * @param  string|null  $name
     * @param  mixed  $default
     *
     * @return mixed
     */
    public function value($name = null, $default = null)
    {
        return $this->getAttribute('content.value'.($name ? ".$name" : ''), $default);
    }

    /**
     * @param $name
     * @param  null  $default
     *
     * @return mixed
     */
    public function option($name, $default = null)
    {
        return $this->getAttribute("content.options.{$name}", $this->getAttribute("field.options.{$name}", $default));
    }

    /**
     * @return bool
     */
    public function isQuestion()
    {
        return $this->category === self::CATEGORY_QUESTION;
    }

    /**
     * @return bool
     */
    public function isContent()
    {
        return $this->category === self::TYPE_CONTENT;
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->blockType::render($this);
    }
}
