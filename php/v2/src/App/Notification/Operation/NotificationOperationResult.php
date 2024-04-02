<?php

class NotificationOperationResult
{
    private bool $notificationEmployeeByEmail = false;
    private bool $notificationClientByEmail = false;
    private bool $notificationClientBySmsSent = false;
    private string $notificationClientBySmsMessage = '';

    public function setNotificationEmployeeByEmail(bool $notificationEmployeeByEmail): void
    {
        $this->notificationEmployeeByEmail = $notificationEmployeeByEmail;
    }

    public function setNotificationClientByEmail(bool $notificationClientByEmail): void
    {
        $this->notificationClientByEmail = $notificationClientByEmail;
    }

    public function setNotificationClientBySmsSent(bool $notificationClientBySmsSent): void
    {
        $this->notificationClientBySmsSent = $notificationClientBySmsSent;
    }

    public function setNotificationClientBySmsMessage(string $notificationClientBySmsMessage): void
    {
        $this->notificationClientBySmsMessage = $notificationClientBySmsMessage;
    }

    public function toArray(): array
    {
        return [
            'notificationEmployeeByEmail' => $this->notificationEmployeeByEmail,
            'notificationClientByEmail' => $this->notificationClientByEmail,
            'notificationClientBySms' => [
                'isSent' => $this->notificationClientBySmsSent,
                'message' => $this->notificationClientBySmsMessage,
            ],
        ];
    }
}