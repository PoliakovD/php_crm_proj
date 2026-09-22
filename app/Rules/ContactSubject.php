<?php

namespace App\Rules;

use App\Models\ContactType;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ContactSubject implements ValidationRule, DataAwareRule
{
    protected array $data = [];
    protected ?string $type = null;

    public function __construct(
        protected string $typesKey = 'contact_types',
        protected string $idKey = 'id'
    ) {}

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // $attribute = 'contact_types.0.subject'
        // вытаскиваем индекс "0"
        $parts = explode('.', $attribute);
        $index = $parts[count($parts) - 2] ?? null;

        $typeId = $this->data[$this->typesKey][$index][$this->idKey] ?? null;

        $this->type = $typeId
            ? ContactType::query()->find($typeId)?->type
            : null;

        if (! is_string($value) || trim($value) === '') {
            $fail('Значение поля :attribute не может быть пустым.');
            return;
        }

        $value = trim($value);

        $ok = match ($this->type) {
            'number'    => $this->isPhone($value),
            'telegram'  => $this->isTelegram($value),
            'whatsapp'  => $this->isWhatsapp($value),
            'instagram' => $this->isSocialLink($value, 'instagram.com') || $this->isUsername($value),
            'facebook'  => $this->isSocialLink($value, 'facebook.com')
                || $this->isSocialLink($value, 'fb.com')
                || $this->isUsername($value),
            'twitter'   => $this->isSocialLink($value, 'twitter.com')
                || $this->isSocialLink($value, 'x.com')
                || $this->isUsername($value),
            'linkedin'  => $this->isSocialLink($value, 'linkedin.com') || $this->isUsername($value),
            'vk'        => $this->isSocialLink($value, 'vk.com') || $this->isUsername($value),
            null, ''    => true,
            default     => true,
        };

        if (! $ok) {
            $fail($this->message());
        }
    }

    protected function message(): string
    {
        return match ($this->type) {
            'number'    => 'Поле :attribute должно быть корректным номером телефона.',
            'telegram'  => 'Поле :attribute должно быть ссылкой на Telegram (t.me/...) или @username.',
            'whatsapp'  => 'Поле :attribute должно быть номером телефона или ссылкой wa.me/...',
            'instagram' => 'Поле :attribute должно быть ссылкой на Instagram или ником.',
            'facebook'  => 'Поле :attribute должно быть ссылкой на Facebook или ником.',
            'twitter'   => 'Поле :attribute должно быть ссылкой на Twitter/X или ником.',
            'linkedin'  => 'Поле :attribute должно быть ссылкой на LinkedIn или ником.',
            'vk'        => 'Поле :attribute должно быть ссылкой на VK или ником.',
            default     => 'Поле :attribute имеет неверный формат.',
        };
    }

    protected function isPhone(string $value): bool
    {
        if (! preg_match('/^\+?[\d\s\-\(\)]{7,20}$/', $value)) {
            return false;
        }
        return preg_match_all('/\d/', $value) >= 7;
    }

    protected function isTelegram(string $value): bool
    {
        if (preg_match('~^(https?://)?t\.me/[A-Za-z0-9_]{4,32}$~i', $value)) {
            return true;
        }
        return $this->isUsername($value);
    }

    protected function isWhatsapp(string $value): bool
    {
        if (preg_match('~^(https?://)?(wa\.me|api\.whatsapp\.com)/\d{7,15}$~i', $value)) {
            return true;
        }
        return $this->isPhone($value);
    }

    protected function isSocialLink(string $value, string $domain): bool
    {
        $domain = preg_quote($domain, '~');
        return (bool) preg_match(
            '~^(https?://)?(www\.)?' . $domain . '/[A-Za-z0-9_./\-?=&%]+$~i',
            $value
        );
    }

    protected function isUsername(string $value): bool
    {
        return (bool) preg_match('/^@?[A-Za-z0-9._]{3,32}$/', $value);
    }
}
