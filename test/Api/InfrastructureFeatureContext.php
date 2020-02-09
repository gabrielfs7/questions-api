<?php declare(strict_types=1);

namespace Questions\Test\Api;

use Behat\Behat\Context\Context;
use Psr\Http\Message\ResponseInterface;
use Questions\Test\AppSupportTrait;

class InfrastructureFeatureContext implements Context
{
    use AppSupportTrait;

    /** @var ResponseInterface */
    protected $response;

    /** @var string */
    protected $url;

    /** @var string */
    protected $contentType;

    /** @var string */
    protected $contentAccept;

    public function __construct()
    {
        $this->url = '/questions';
        $this->contentType = 'application/json';
        $this->contentAccept = 'application/json';
    }

    /**
     * @Given a not existent url :arg1
     */
    public function givenANotExistentUrl(?string $url)
    {
        $this->url = $url;
    }

    /**
     * @Given a invalid Content-Type :arg1 or Accept :arg2
     */
    public function givenAInvalidContentTypeOrContentAccept(?string $contentType, $contentAccept)
    {
        $this->contentType = $contentType;
        $this->contentAccept = $contentAccept;
    }

    /**
     * @When user submits request
     */
    public function userSubmitsRequest()
    {
        $this->response = $this->request(
            'POST',
            $this->url,
            null,
            [],
            [
                'Accept' => $this->contentAccept,
                'Content-Type' => $this->contentType,
            ]
        );
    }

    /**
     * @Then a error response with status code :arg1 and JSON error :arg2 is returned
     */
    public function anErrorIsReturned(string $statusCode, string $errorMessage)
    {
        $this->assertJsonResponseContains(
            $this->response,
            [
                'code' => (int)$statusCode,
                'message' => $errorMessage
            ]
        );
        $this->assertResponseStatusCode($this->response, (int)$statusCode);
    }
}
