pipeline {
    agent {
        docker {
            image 'duchnuon/lrl-ci-image:php8.2'
            args '-u root:root'
        }
    }
    
    triggers {
        githubPush()
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Check Composer Version') {
            steps {
                sh 'composer --version'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install --prefer-dist --no-progress --no-interaction'
                sh 'composer --version'
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
