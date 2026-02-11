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

        stage('Setup Composer') {
            steps {
                sh 'curl -sSLo /usr/local/bin/composer https://getcomposer.org/download/2.8.4/composer.phar && chmod +x /usr/local/bin/composer'
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
