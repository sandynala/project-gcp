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
                                    sh "docker stop d45d2555c59f"
                                    sh "docker rm d45d2555c59f"
                                    sh "echo docker run started"
                                    sh "docker run -dit --name wp-cont -p 8000:80 hmwordpress:latest"
                                    sh "docker ps -a"
                                    sh "docker images"
                                    sh "echo dockerimage pushing to gcr"
                                    sh "docker tag hmwordpress gcr.io/hmwordpress:latest"
                                    sh "docker images"
                                    sh "docker push gcr.io/hmwordpress:latest"

			    }
		    }
	    }
 }

}


