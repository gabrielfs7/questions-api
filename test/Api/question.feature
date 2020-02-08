Feature: Questions

  Scenario Outline: Create a question
    Given a question with text <text>, createdAt <createdAt> and choices <choice1>, <choice2>, <choice3>
    When user submits POST request
    Then a response with status code <statusCode> and JSON with the created question is returned
    Examples:
      | text         | createdAt                   | choice1    | choice2    | choice3    | statusCode |
      | "Question 1" | "2020-02-08T07:50:45+00:00" | "Choice 1" | "Choice 2" | "Choice 3" | 200        |

  Scenario Outline: List questions
    Given the lang <lang>
    When user submits GET request
    Then a response with status code <statusCode> and JSON list with previous question <text>, createdAt <createdAt> and choices <choice1>, <choice2>, <choice3> is returned

    Examples:
      | lang | text         | createdAt                   | choice1    | choice2    | choice3    | statusCode |
      | en   | "Question 1" | "2020-02-08T07:50:45+00:00" | "Choice 1" | "Choice 2" | "Choice 3" | 200        |