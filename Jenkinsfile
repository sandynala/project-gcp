pipeline {
    agent any
	tools {
		maven 'Maven'
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
			    script {
				    sh "docker build -t hmwordpress:latest ."
                                    sh "docker ps -a"
                                    sh "docker stop 8bd6f04bffa9"
                                    sh "docker rm 8bd6f04bffa9"
                                    sh "echo docker run started"
                                    sh "docker run -dit --name wp-cont -p 8000:80 hmwordpress:latest"
                                    sh "docker ps -a"
                                    sh "docker images"
                                    sh "echo dockerimage pushing to gcr"
                                    sh "gcloud auth configure-docker"
                                    sh "docker tag hmwordpress gcr.io/gcp-hmwordpress:v1"
                                    sh "docker images"
                                    sh "sudo docker push gcr.io/gcp-hmwordpress:v1"

			    }
		    }
	    }
 }

}


