pipeline {
    agent {
        docker {
            image 'composer:latest'
            args '-u root'
        }
    }
    
    triggers {
        githubPush()
    }

    stages {
        stage('Checkout') {
            steps {
                sh 'git config --global --add safe.directory "${WORKSPACE}"'
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev'
                sh 'docker-php-ext-configure gd --with-freetype --with-jpeg'
                sh 'docker-php-ext-install gd'
                sh 'composer install --prefer-dist --no-progress --no-interaction'
            }
        }

        stage('Run Tests') {
            steps {
                sh 'vendor/bin/phpunit --testdox'
            }
        }
    }

    post {
        always {
            cleanWs()
        }
        success {
            echo 'Tests passed successfully!'
        }
        failure {
            echo 'Tests failed!'
        }
    }
}
