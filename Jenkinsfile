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
				    sh "docker build -t gcr.io/jenkins51435/hmwordpress:latest ."
                                    sh "docker stop 7a59e8dfd2e1"
                                    sh "docker ps -a"
                                    sh "docker rm 7a59e8dfd2e1"
                                    sh "echo docker pushing to gcr"
                                    sh "docker push gcr.io/jenkins51435/hmwordpress:latest
                                    sh "echo docker pushed successfully to gcr"
                                    sh "echo docker run started"
                                    sh "docker run -dit --name wp-cont -p 8000:80 hmwordpress:latest"
                                    sh "docker ps -a"
                                    sh "docker images"

			    }
		    }
	    }
 }

}


docker build -t gcr.io/<projectid>/reponame:tag