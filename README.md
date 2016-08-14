# home_automation_application
A PHP Web application that provide interface to a home automation system

There should be an already setup home automation system which can then post home sensors 
data to the web application via a predefined url after which this data is saved on the database

Accessing the web application provides access to the data already posted and thus giving one 
remote access to their home condition

From the web application a logged on user can also send commands to the home automation system
that can enable the turning on or off of devices remotely. 

The home automation system composed of a gsm module that provided gprs access to post the commands 
to the website and gsm access to receive notification texts from gmail that bear the commands from 
the web application  
