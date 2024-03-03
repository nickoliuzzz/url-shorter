There are some moments I want to mention

I used https://www.virustotal.com instead of google service because it has free trial.
If you want to try use it locally, I can give you key or help to generate

Now on all envs except production used UrlCheckerLocal that only mock checking url

**Dump of database is in file backup.sql in root of project.**

For backend side there are a lot of improvements that could be added.
Some of them are:

* Some kind of caching of often used data (for any url which was asked or just created we could expect that it will be called again soon)
* Checking of correct url should be moved from validation of request to last step before saving to database (because it's the most heavy part of this request and if we already have such url we don't need to check it again)
