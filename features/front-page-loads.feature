Feature: Application front-page
    In order for users to interact with the application
    As a visitor
    I want to be able to load the front-page in my browser

    @javascript
    Scenario: Loading the front-page
        Given I am on homepage
        Then I should see "Etusivu"
