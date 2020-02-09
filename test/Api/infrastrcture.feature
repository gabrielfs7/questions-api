Feature: Questions Infrastructure

  Scenario Outline: Not existent url should return "Not Found" http Error
    Given a not existent url <url>
    When user submits request
    Then a error response with status code <statusCode> and JSON error <error> is returned
    Examples:
      | url               | statusCode | error        |
      | "/questions-form" | 404        | "Not found." |

  Scenario Outline: A no support Content-Type or Accept headers must return Http error
    Given a invalid Content-Type <contentType> or Accept <accept>
    When user submits request
    Then a error response with status code <statusCode> and JSON error <error> is returned
    Examples:
      | contentType        | accept             | statusCode | error                                                   |
      | "text/html"        | "application/json" | 500        | "Content-Type text/html is not supported"               |
      | "text/xml"         | "application/json" | 500        | "Content-Type text/xml is not supported"                |
      | "application/json" | "text/html"        | 406        | "Content Accept text/html is not supported as response" |
      | "application/json" | "text/xml"         | 406        | "Content Accept text/xml is not supported as response"  |