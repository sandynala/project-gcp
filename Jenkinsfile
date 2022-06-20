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
				    sh "docker build -t hmwordpress ."
                                    sh "docker stop 7ba4 19c2 4eb4"
                                    sh "docker ps -a"
                                    sh "docker rm 7ba4 19c2 4eb4"
                                    sh "docker run -dit --name wp-cont -p 8000:80 hmwordpress:latest"
                                    sh "docker ps -a"
                                    sh "docker images"

			    }
		    }
	    }
 }

}