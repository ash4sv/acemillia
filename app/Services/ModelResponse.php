<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use RealRashid\SweetAlert\Facades\Alert;

class ModelResponse
{
    protected string $type = 'success';
    protected string $title = 'Success!';
    protected string $message = 'Operation completed.';
    protected ?string $redirect = null;
    protected array $data = [];

    public static function make(): self
    {
        return new self();
    }

    public static function success(string $message = 'Success!'): self
    {
        return self::make()->type('success')->message($message)->title('Success!');
    }

    public static function error(string $message = 'Something went wrong.'): self
    {
        return self::make()->type('error')->message($message)->title('Error!');
    }

    public static function warning(string $message = 'Please check your input.'): self
    {
        return self::make()->type('warning')->message($message)->title('Warning!');
    }

    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function redirect(string $url): self
    {
        $this->redirect = $url;
        return $this;
    }

    public function withData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function close()
    {
        return response()->json($this->toArray());
    }

    public function toArray(): array
    {
        return array_merge([
            'modal'   => true,
            'type'    => $this->type,
            'title'   => $this->title,
            'message' => $this->message,
            'redirect'=> $this->redirect,
        ], $this->data);
    }
}
