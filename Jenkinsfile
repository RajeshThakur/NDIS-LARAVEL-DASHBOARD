pipeline {
  agent any
  stages {
    stage('Deploy') {
      environment {
        FTP_USER = 'admin_ndisapp'
        FTP_PASS = 'a80FrTTGAZ'
      }
      steps {
        sh 'git ftp push --user $FTP_USER --passwd $FTP_PASS --syncroot . "ftp://3.106.7.176/public_html"'
      }
    }
  }
}