<?php declare(strict_types=1);

namespace Questions\Test\Api;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;
use Questions\Test\AppSupportTrait;
use Questions\Test\DbSupportTrait;

class QuestionsFeatureContext implements Context
{
    use AppSupportTrait;
    use DbSupportTrait;

    /** @var string */
    protected $lang;

    /** @var array */
    protected $currentQuestion;

    /** @var ResponseInterface */
    protected $response;

    public function __construct()
    {
        self::initDatabase();
    }

    /**
     * @Given a incorrect question with text :arg1, createdAt :arg2 and choices :arg3
     */
    public function givenAWrongQuestion(
        ?string $text,
        ?string $createdAt,
        ?string $choices
    ) {
        $choices = explode(',', (string)$choices);
        $choice1 = $choices[0] ?? null;
        $choice2 = $choices[1] ?? null;
        $choice3 = $choices[2] ?? null;

        $this->currentQuestion = $this->createQuestion($text, $createdAt, $choice1, $choice2, $choice3);
    }

    /**
     * @Then a response with status code :arg1 and JSON error :arg2 is returned
     */
    public function newQuestionCannotBeCreated(string $statusCode, string $errorMessage)
    {
        $this->assertJsonResponseContains(
            $this->response,
            [
                'code' => 0,
                'message' => $errorMessage
            ]
        );
        $this->assertResponseStatusCode($this->response, (int)$statusCode);
    }

    /**
     * @Given a question with text :arg1, createdAt :arg2 and choices :arg3, :arg4, :arg5
     */
    public function givenANewQuestion(
        string $text,
        string $createdAt,
        string $choice1,
        string $choice2,
        string $choice3
    ) {
        $this->currentQuestion = $this->createQuestion($text, $createdAt, $choice1, $choice2, $choice3);
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
            $this->currentQuestion,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    /**
     * @Then a response with status code :arg1 and JSON with the created question is returned
     */
    public function newQuestionIsCreated(string $statusCode)
    {
        $this->assertJsonResponseContains($this->response, $this->currentQuestion);
        $this->assertResponseStatusCode($this->response, (int)$statusCode);
    }

    /**
     * @Given an invalid lang :arg1
     */
    public function givenAnInvalidLang(string $lang)
    {
        $this->lang = $lang;
    }

    /**
     * @Given the lang :arg1
     */
    public function givenALang(string $lang)
    {
        $this->lang = $lang;
    }

    /**
     * @When user submits GET request
     */
    public function userSubmitsGet()
    {
        $this->response = $this->findQuestions();
    }

    /**
     * @Then a response with status code :arg1 and JSON list with previous questions :arg2 and choices :arg3 is returned
     */
    public function aListOfQuestionIsReturned(string $statusCode, string $allQuestions, string $allChoices)
    {
        $questions = explode(',', $allQuestions);
        $choiceGroups = explode('#', $allChoices);

        $updatedQuestions = json_decode((string)$this->findQuestions()->getBody(), true)['data'];

        for ($i = 0; $i < count($questions); $i++) {
            Assert::assertSame($questions[$i], $updatedQuestions[$i]['text']);

            $choices = explode(',', $choiceGroups[$i]);

            for ($j = 0; $j < count($updatedQuestions[$i]['choices']); $j++) {
                Assert::assertSame($choices[$j], $updatedQuestions[$i]['choices'][$j]['text']);
            }
        }

        $this->assertJsonResponseContains($this->response, ['data' => $updatedQuestions]);
        $this->assertResponseStatusCode($this->response, (int)$statusCode);
    }

    private function createQuestion(?string $text, ?string $createdAt, ?string $choice1, ?string $choice2, ?string $choice3)
    {
        return array_filter(
            [
                'text' => $text,
                'createdAt' => $createdAt,
                'choices' => [
                    [
                        'text' => $choice1
                    ],
                    [
                        'text' => $choice2
                    ],
                    [
                        'text' => $choice3
                    ],
                ]
            ]
        );
    }

    private function findQuestions(): ResponseInterface
    {
        return $this->request(
            'GET',
            '/questions',
            [
                'lang' => $this->lang,
            ],
            [],
            [
                'Content-Type' => 'application/json',
            ]
        );
    }
}
