Feature: Questions

  Scenario Outline: Create a question with invalid parameters must NOT be allowed
    Given a incorrect question with text <text>, createdAt <createdAt> and choices <choices>
    When user submits POST request
    Then a response with status code <statusCode> and JSON error <error> is returned
    Examples:
      | text         | createdAt                   | choices                      | statusCode | error                                                         |
      | "Question 1" | "2020-02-08T07:50:45+00:00" | "Choice 1,Choice 2"          | 400        | "Choice text must be a string. NULL given"                    |
      | ""           | "2020-02-08T07:50:45+00:00" | "Choice 1,Choice 2,Choice 3" | 400        | "Question text must be a string. NULL given"                  |
      | "Question 1" | ""                          | "Choice 1,Choice 2,Choice 3" | 400        | "Question createdAt must be a valid date-time. NULL given"    |
      | "Question 1" | "invalid"                   | "Choice 1,Choice 2,Choice 3" | 400        | "Question createdAt must be a valid date-time. invalid given" |

  Scenario Outline: Create a question
    Given a question with text <text>, createdAt <createdAt> and choices <choice1>, <choice2>, <choice3>
    When user submits POST request
    Then a response with status code <statusCode> and JSON with the created question is returned
    Examples:
      | text         | createdAt                   | choice1      | choice2      | choice3      | statusCode |
      | "Question 1" | "2020-02-08T07:50:45+00:00" | "Choice 1_1" | "Choice 1_2" | "Choice 1_3" | 200        |
      | "Question 2" | "2020-02-09T07:50:45+00:00" | "Choice 2_1" | "Choice 2_2" | "Choice 2_3" | 200        |

  Scenario Outline: List questions with invalid language must NOT be allowed
    Given an invalid lang <lang>
    When user submits GET request
    Then a response with status code <statusCode> and JSON error <error> is returned
    Examples:
      | lang | statusCode | error                                                        |
      | xx   | 400        | "Parameter lang must be a ISO-639-1 language code. xx given" |
      | ""   | 400        | "Parameter lang must be a ISO-639-1 language code.  given"   |
      | 00   | 400        | "Parameter lang must be a ISO-639-1 language code. 00 given" |

  Scenario Outline: List questions by language
    Given the lang <lang>
    When user submits GET request
    Then a response with status code <statusCode> and JSON list with previous questions <questions> and choices <choices> is returned

    Examples:
      | lang | statusCode | questions               | choices                                                                   |
      | en   | 200        | "Question 1,Question 2" | "Choice 1_1,Choice 1_2,Choice 1_3#Choice 2_1,Choice 2_2,Choice 2_3"       |
      | pt   | 200        | "Questão 1,Questão 2"   | "Escolha 1_1,Escolha 1_2,Escolha 1_3#Escolha 2_1,Escolha 2_2,Escolha 2_3" |