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
                sh 'apk add --no-cache zlib-dev freetype-dev libjpeg-turbo-dev libpng-dev libxml2-dev libzip-dev oniguruma-dev'
                sh 'docker-php-ext-configure gd --with-freetype --with-jpeg'
                sh 'docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring xml dom curl zip'
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
