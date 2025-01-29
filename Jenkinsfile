pipeline {
	agent any
	environment {
        INSTANCE_IP = sh(script: 'curl -s ifconfig.me', returnStdout: true).trim()
    }
	stages {
		stage ('Updating settings') {
            steps {
				script {
					echo "Replacing with the instance IP in prometheus.yml"
					sh '''
					sed -i "s|<INSTANCE_IP>|${INSTANCE_IP}|g" docker/prometheus/prometheus.yml
					'''

					echo "Replacing localhost with instance IP in app.js"
					sh '''
					sed -i "s|const API_URL = \\"http://localhost:8000\\";|const API_URL = \\"http://${INSTANCE_IP}:8000\\";|g" frontend/app.js
					'''
                }
            }
        }
		stage ('Prepare .env file') {
			steps {
				script {
					echo "Setting values ​​of .env"
					sh """
					cat > .env <<EOF
					DATABASE=${DATABASE}
					MYSQL_ROOT_USER=${MYSQL_ROOT_USER}
					MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}
					MYSQL_USER=${MYSQL_USER}
					MYSQL_PASSWORD=${MYSQL_PASSWORD}
					TIMEZONE=${DATABASE}
					EOF
					"""
				}
			}
		}
		stage ('Build docker images'){
			steps {
				sh 'docker compose build'	
			}
		}
		stage ('Installing dependencies') {
            steps {
                script {
                    echo 'Installing composer and cypress dependencies...'
                    sh 'cd backend && composer install'
					sh 'cd cypress && npm install'
                }
            }
        }
		stage ('Unit test'){
			steps {
				sh './backend/vendor/bin/phpunit --bootstrap backend/vendor/autoload.php backend/tests/UserUnitTest.php'
			}
		}
		stage ('Running docker images'){
			steps {
				sh 'docker compose up -d --build'	
			}
		}
		stage ('Waiting time'){
			steps {
				echo 'Waiting time for containers to become available...'
				sh 'sleep 10'
			}
		}
		stage ('Running E2E interface tests'){
			steps {
				echo 'Running automated UI tests with Cypress'
				sh 'cd cypress && npx cypress run --spec "cypress/e2e/spec.cy.js"'	
			}
		}
	}
}