pipeline {
    agent any
	tools {
		maven 'Maven'
	}	

      environment {
		PROJECT_ID = 'jenkins51435'
                CLUSTER_NAME = 'k8s-cluster'
                LOCATION = 'us-central1-c'
                CREDENTIALS_ID = 'kubernetes'		
	}
	
    stages {
	    stage('Scm Checkout') {
		    steps {
			    checkout scm
		    }
	    }
	    
	    stage('Build') {
		    steps {
			    sh 'mvn clean package'
		    }
	    }
	    
	    stage('Test') {
		    steps {
			    echo "Testing..."
			    sh 'mvn test'
		    }
	    }
	    
	    stage('Build Docker Image') {
		    steps {
			    sh 'whoami'
                            sh 'df -h'
			    script {
				    sh "docker build -t hmwordpress:latest ."
                                    sh "docker ps -a"
                                    sh "docker rm ${docker ps -a -q}"
                                    sh "echo docker run started"
                                    sh "docker run -dit --name wp-cont -p 8000:80 hmwordpress:latest"
                                    sh "docker ps -a"
                                    sh "docker images"
                                    sh "echo dockerimage pushing to gcr..."
                                    sh "gcloud auth configure-docker"
                                    sh "docker tag hmwordpress gcr.io/jenkins51435/gcp-hmwordpress:v3"
                                    sh "docker images"
                                    sh "sudo docker push gcr.io/jenkins51435/gcp-hmwordpress:v3"
                                    sh "echo docker image pushed sucessfully to gcr"

			    }
		    }
	    }


          stage('Deploy to K8s') {
		    steps{
			    echo "Deployment started ..."
			    sh 'ls -ltr'
			    sh 'pwd'
			    sh "sed -i 's/tagversion/${env.BUILD_ID}/g' gcpwordpress-deployment.yml"
			    echo "Start deployment of deployment.yml"
			    step([$class: 'KubernetesEngineBuilder', projectId: env.PROJECT_ID, clusterName: env.CLUSTER_NAME, location: env.LOCATION, manifestPattern: 'gcpwordpress-deployment.yml', credentialsId: env.CREDENTIALS_ID, verifyDeployments: true])
			    echo "Deployment Finished ..."
		    }
	    }
    }
}

