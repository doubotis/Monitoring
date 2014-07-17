Monitoring
==========
![alt tag](https://raw.githubusercontent.com/doubotis/Monitoring/master/docs/monitoring-sample.png)

==========

Introduction
------------------
Monitoring Web Application allows management of servers.
The application includes several systems, as :
* Controllers
* Alarms
* Alerts
* Logs
* Shorcuts
* Users
* Permissions
* Projects
* Administration
* Plugin Technology

Controllers
-----------
A controller is a control the application does every X minutes. It's defining something to control. If the control fails as describing in the Control Type, an alert is triggered.

A controller can control with different cases :
* Status code of HTTP request
* Result set of a database query
* Body Answer of HTTP request
* ...

The manner to control is featured with plugin technology, so adding new control types is simple. Want to check the presence of a process inside UNIX ? Code it and let's rock.
