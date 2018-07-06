# hibp-search
Using Have I Been Pwned API, this PHP software checks a list of emails against HIBP database and reports on emails found in the database. This is an easy way to check if a list of email has items in leaked user databases.

## Usage
You need a local or onlnie webserver to use this. Copy the files in a folder in www or htdocs, and it is ready to use. The base password is **admin**. Change this as soon as possible, especially if you use it on an online webserver.

## Setup
In the *req* folder you find a *settings.php* file. Edit this to customize the program. You can turn off password protection, change language and this is where you set up your own email list too.

Put your email address list in the *lists* folder, then in the *settings.php* edit the $fileName variable to match the list file's name. Any txt file works, you do not have to format it any way, the only condition is that email addresses should be seperated somehow.

## Design
I made this whole thing on the fly without planning to use it at my company. We didn't use it as the management couldn't trust an outside server (the API) to check the emails this way. Because I built this fast it uses mixed PHP and HTML, no templating. For the API calls it uses javascript / ajax, that also mixed with PHP for settings. I do not really like this kind of programming (most of the time I keep php, javascript and HTML seperate), but this was faster this way.

The password protection and language support is me overdoing it after it falid to being used at work and started planning to upload it here.

