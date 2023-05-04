<?php

namespace DevelopersSavyour\OpenAI;

use DevelopersSavyour\OpenAI\Exceptions\ApiKeyIsMissing;
use GuzzleHttp\Client;

class OpenAIClient
{
    protected $baseUrl = 'https://api.openai.com/v1/';

    protected $client;

    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->baseUrl]);
        $this->apiKey = config('openai.api_key');

        if (empty($this->apiKey)) {
            throw ApiKeyIsMissing::create();
        }
    }

    /**
     * Generates text based on a prompt and the specified model.
     *
     * @param string $prompt The prompt to generate text from.
     * @param string $model The name of the model to use.
     * @param int $length The maximum length of the generated text.
     * @param float $temperature The temperature to use for sampling.
     * @param int $maxTokens The maximum number of tokens to generate.
     * @param string|null $stop The stop sequence to use for text generation.
     * @return string The generated text.
     */
    public function generateText($prompt, $model, $length = 1024, $temperature = 0.5, $maxTokens = 1024, $stop = null)
    {
        $data = [
            'prompt' => $prompt,
            'model' => $model,
            'temperature' => $temperature,
            'max_tokens' => $maxTokens,
            'n' => 1,
            'stop' => $stop,
            'length' => $length,
        ];

        $response = $this->client->post('engines/' . $model . '/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
            'json' => $data,
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['choices'][0]['text'])) {
            return $result['choices'][0]['text'];
        } else {
            throw new \RuntimeException('Failed to generate text: ' . $result['error']);
        }
    }

    /**
     * Retrieves a list of all available models.
     *
     * @return array The list of models.
     */
    public function listModels()
    {
        $response = $this->client->get('models', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['data'])) {
            return $result['data'];
        } else {
            throw new \RuntimeException('Failed to list models: ' . $result['error']);
        }
    }

    /**
     * Retrieves information about the specified model.
     *
     * @param string $model The name of the model to retrieve information for.
     * @return array The model information.
     */
    public function getModel($model)
    {
        $response = $this->client->get('models/' . $model, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['data'])) {
            return $result['data'];
        } else {
            throw new \RuntimeException('Failed to get model ' . $model . ': ' . $result['error']);
        }
    }

    /**
     * Creates embeddings for the specified text using the specified model.
     *
     * @param string|array $text The text or texts to create embeddings for.
     * @param string $model The name of the model to use.
     * @return array The embeddings for the text.
     */
    public function createEmbeddings($text, $model)
    {
        if (is_array($text)) {
            $data = ['documents' => $text];
        } else {
            $data = ['documents' => [$text]];
        }

        $response = $this->client->post('engines/'.$model.'/embeddings', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->apiKey,
            ],
            'json' => $data,
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['data'][0]['embedding'])) {
            return $result['data'][0]['embedding'];
        } else {
            throw new \RuntimeException('Failed to create embeddings: '.$result['error']);
        }
    }

    /**
     * Retrieves the usage statistics for your OpenAI API key.
     *
     * @return array The usage statistics.
     */
    public function getUsage()
    {
        $response = $this->client->get('usage', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->apiKey,
            ],
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['data'])) {
            return $result['data'];
        } else {
            throw new \RuntimeException('Failed to get usage: '.$result['error']);
        }
    }
}
