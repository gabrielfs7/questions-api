<?php

namespace Questions\Test\Api;

use Behat\Behat\Context\Context;
use Psr\Http\Message\ResponseInterface;
use Questions\Test\AppTestTrait;

class QuestionsFeatureContext implements Context
{
    use AppTestTrait;

    /** @var string */
    protected $lang;

    /** @var array */
    protected $question;

    /** @var ResponseInterface */
    protected $response;

    public function __construct()
    {
        $this->initDatabase();
    }

    /**
     * @Given a question with text :arg1, createdAt :arg2 and choices :arg3, :arg4, :arg5
     */
    public function giveANewQuestion(
        string $text,
        string $createdAt,
        string $choice1,
        string $choice2,
        string $choice3
    )
    {
        $this->question = $this->createQuestion($text, $createdAt, $choice1, $choice2, $choice3);
    }

    /**
     * @When user submits POST request
     */
    public function userSubmitsPost()
    {
        $this->response = $this->request(
            'POST',
            '/questions',
            null,
            $this->question
        );
    }

    /**
     * @Then a response with status code :arg1 and JSON with the created question is returned
     */
    public function newQuestionIsCreated(string $statusCode)
    {
        $this->assertJsonResponseContains($this->response, $this->question);
        $this->assertResponseStatusCode($this->response, (int)$statusCode);
    }

    /**
     * @Given the lang :arg1
     */
    public function giveALang(string $lang)
    {
        $this->lang = $this->lang = $lang;
    }

    /**
     * @When user submits GET request
     */
    public function userSubmitsGet()
    {
        $this->response = $this->request(
            'GET',
            '/questions',
            [
                'lang' => $this->lang,
            ]
        );
    }

    /**
     * @Then a response with status code :arg1 and JSON list with previous question :arg2, createdAt :arg3 and choices :arg4, :arg5, :arg6 is returned
     */
    public function aListOfQuestionIsReturned(
        string $statusCode,
        string $text,
        string $createdAt,
        string $choice1,
        string $choice2,
        string $choice3
    )
    {
        $question = $this->createQuestion($text, $createdAt, $choice1, $choice2, $choice3);

        $this->assertJsonResponseContains($this->response, [$question]);
        $this->assertResponseStatusCode($this->response, (int)$statusCode);
    }

    private function createQuestion(string $text, string $createdAt, string $choice1, string $choice2, string $choice3)
    {
        return [
            "text" => $text,
            "createdAt" => $createdAt,
            "choices" => [
                [
                    "text" => $choice1
                ],
                [
                    "text" => $choice2
                ],
                [
                    "text" => $choice3
                ],
            ]
        ];
    }
}
