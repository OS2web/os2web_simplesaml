# OS2Web SimpleSAML Drupal module  [![Build Status](https://travis-ci.org/OS2web/os2web_simplesaml.svg?branch=8.x)](https://travis-ci.org/OS2web/os2web_simplesaml)

# Module purpose

The aim of this module is to enhance integration with **simplesamlphp_auth** module, by force triggering **SimpleSAML auth page** redirect when certain criteria are met. 

# How does it work

Module performs checks on a single redirect triggering page. In order for it to work the cache for anonymous user for that page response is programmatically killed.

The redirect check cannot be done on all pages. Reason for that is the performance. The redirect only works properly when page response cache is killed (otherwise response is cached for all anonymous users), so in order for it to work on all pages anonymous page response caches must be killed (which is the same as disabling page cache entirely).

As a compromise between the functionality and performance it has been decided to use a single page to trigger redirect check.

If the request passes all the criteria (meaning user is anonymous and the IP is within whitelist), request is redirected to **SimpleSAML auth page**.

To improve the performance, the redirect decision is stored in cookies to a limited time.

Additionally module provides a special field for user entity, called **SimpleSAML UID** that allows to create a **SimpleSAML mapping** with the existing Drupal users.

# Additional setings

- **IP's whitelist**
Comma separate values of IP or IP ranges that will be redirected to SimpleSAML auth page. 
- **Redirect triggering page**
A certain page that triggers the redirect to SimpleSAML auth page if the criteria pass (_defaults: front page "/"_).
- **Cookies TTL**
Stores the redirect response in the cookies for a certain period of time (_defaults: 5min_).

