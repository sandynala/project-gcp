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
                                    sh "docker ps -a"
                                    sh "docker run -dit --name wp1-cont -p 9000:80 hmwordpress:latest"
                                    sh "docker ps -a"
                                    sh "docker images"

			    }
		    }
	    }
 }

}