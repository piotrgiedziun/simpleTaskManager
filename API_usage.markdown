##API Usage - Example Code

```html
import urllib, urllib2,  json,  hashlib, os
 
URL = 'http://127.0.0.1:8080/api/'
 API_SECRET_KEY = 'WE0qYaHBpC6UDsVGFCC'
 

def sendPost(url, parms, sign=False):
     try:
         if sign:
             parms['signature'] = signature(parms)
         
         data = urllib.urlencode(parms)          
         req = urllib2.Request(url, data)
 

       print data
         response = urllib2.urlopen(req)
         the_page = response.read() 
         print the_page 
         return json.loads(the_page)
     except Exception, detail: 
         print "Err ", detail 
 

def signature(parms):    
     hash = hashlib.md5()
     hash.update(API_SECRET_KEY+user_token+('&'.join(['%s=%s' % (key, value) for key, value in parms.items()][:])))
     return hash.hexdigest()
 

def update():
     print sendPost(URL+'tasks/update', {
         'session_token': session_token,
         'status_id': 0,
         'task_id': 3
     }, True)
 

def get():
     print sendPost(URL+'tasks/get', {
         'session_token': session_token
     }, True)
  
 

def insert():
     pass
 

def create_account():
     username = raw_input('Username: ');
     password = raw_input('Password: ');
     mail = raw_input('Mail:');
     print sendPost(URL+'user/create', {
         'username': username,
        'password': password,
        'mail': mail
     })
 

#get user token
 user_pass = hashlib.md5()
 user_pass.update('test')
 

user_token = sendPost(URL+'get_user_token',  {
     'username' : 'test',
     'password' : user_pass.hexdigest()
 })['user_token']
 

#get session token
 session_token = sendPost(URL+'get_session_token', {})['session_token']
 

#assign session
 user_token_hash = hashlib.md5()
 user_token_hash.update(user_token+session_token)
 sendPost(URL+'assign', {
     'session_token' : session_token,
     'user_token_hash' : user_token_hash.hexdigest()
 } )
 

#print data
 print 'user_token=%s\nsession_token=%s' % (user_token, session_token)
 

#menu system
 while(True):
     option = raw_input('MENU:\n1) get\n2) update\n3) insert\n4) create account\nq) quit\n ')
     
     if option == 'q':
         print 'Bye Bye!'
         break
 

    try:
         os.system('clear')
         {'1':get, '2':update, '3':insert,'4':create_account,}[option]()
         raw_input('Press any key to continue...')
         os.system('clear')
     except KeyError:
         pass
```