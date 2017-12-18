[![build status](https://travis-ci.org/starekrow/travis-custom-example.svg?branch=master)](https://travis-ci.org/starekrow/travis-custom-example)

Travis Example
==============

This is just a quick example of using Travis integration with a custom PHP 
test framework. The entire framework fits in one file and is bog-standard
PHP, so it should easily work in 5.5+.

To run the test suite from the command line, clone this repo onto your drive
somewhere, change to that directory and run:

```bash
php tests/TestFramework.php run
```

The output will look something like this:

```
--- ExampleTest ---
[ pass ] Construct
[ pass ] Test Zero
[ pass ] Test Throw
[ pass ] Get Null
[ pass ] Get String

Passed 5 tests
```


Other bits of interest:

  * You can click on that "Build:Passing" image up there to see the Travis-CI
    report. From there, you can see the command-line output of the build against
    each version of PHP.
  * If you look at the list of branches for this repository, you'll see one 
    called "bad-branch" with a red X next to it. Clicking on that X will take 
    you to the Travis-CI page where you can see the output of the test 
    framework (click on one of the build jobs).

