<?php

declare(strict_types=1);

namespace TwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ModerationApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-banned-users
     */
    public function getBannedUsers(string $bearer, string $broadcasterId, array $ids = [], string $before = null, string $after = null, string $first = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
        }

        if ($before) {
            $queryParamsMap[] = ['key' => 'before', 'value' => $before];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        return $this->getApi('moderation/banned', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#get-moderators
     */
    public function getModerators(string $bearer, string $broadcasterId, array $ids = [], string $after = null, string $first = null): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($ids as $id) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $id];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        return $this->getApi('moderation/moderators', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#add-channel-moderator
     */
    public function addChannelModerator(string $bearer, string $broadcasterId, string $userId): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];

        return $this->postApi('moderation/moderators', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#remove-channel-moderator
     */
    public function removeChannelModerator(string $bearer, string $broadcasterId, string $userId): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];

        return $this->deleteApi('moderation/moderators', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#check-automod-status
     */
    public function checkAutoModStatus(string $bearer, string $broadcasterId, string $msgId, string $msgText): ResponseInterface
    {
        $queryParamsMap = $bodyParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        $bodyParamsMap[] = ['key' => 'msg_id', 'value' => $msgId];
        $bodyParamsMap[] = ['key' => 'msg_text', 'value' => $msgText];

        return $this->postApi('moderation/enforcements/status', $bearer, $queryParamsMap, $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#manage-held-automod-messages
     */
    public function manageHeldAutoModMessage(string $bearer, string $userId, string $msgId, string $action): ResponseInterface
    {
        $bodyParamsMap = [];

        $bodyParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        $bodyParamsMap[] = ['key' => 'msg_id', 'value' => $msgId];
        $bodyParamsMap[] = ['key' => 'action', 'value' => $action];

        return $this->postApi('moderation/automod/message', $bearer, [], $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#ban-user
     */
    public function banUser(string $bearer, string $broadcasterId, string $moderatorId, string $userId, string $reason, int $duration = null): ResponseInterface
    {
        $queryParamsMap = $bodyParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        $bodyParamsMap[] = ['key' => 'user_id', 'value' => $userId];
        $bodyParamsMap[] = ['key' => 'reason', 'value' => $reason];

        if ($duration) {
            $bodyParamsMap[] = ['key' => 'duration', 'value' => $duration];
        }

        return $this->postApi('moderation/bans', $bearer, $queryParamsMap, $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#unban-user
     */
    public function unbanUser(string $bearer, string $broadcasterId, string $moderatorId, string $userId): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];

        return $this->deleteApi('moderation/bans', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-automod-settings
     */
    public function getAutoModSettings(string $bearer, string $broadcasterId, string $moderatorId): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        return $this->getApi('moderation/automod/settings', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#update-automod-settings
     */
    public function updateAutoModSettings(string $bearer, string $broadcasterId, string $moderatorId, array $settings): ResponseInterface
    {
        $queryParamsMap = $bodyParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        foreach ($settings as $key => $value) {
            $bodyParamsMap[] = ['key' => $key, 'value' => $value];
        }

        return $this->putApi('moderation/automod/settings', $bearer, $queryParamsMap, $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-blocked-terms
     */
    public function getBlockedTerms(string $bearer, string $broadcasterId, string $moderatorId, int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->getApi('moderation/blocked_terms', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#add-blocked-term
     */
    public function addBlockedTerm(string $bearer, string $broadcasterId, string $moderatorId, string $term): ResponseInterface
    {
        $queryParamsMap = $bodyParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        $bodyParamsMap[] = ['key' => 'term', 'value' => $term];

        return $this->postApi('moderation/blocked_terms', $bearer, $queryParamsMap, $bodyParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#remove-blocked-term
     */
    public function removeBlockedTerm(string $bearer, string $broadcasterId, string $moderatorId, string $termId): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];
        $queryParamsMap[] = ['key' => 'id', 'value' => $termId];

        return $this->deleteApi('moderation/blocked_terms', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#delete-chat-messages
     */
    public function deleteChatMessages(string $bearer, string $broadcasterId, string $moderatorId, string $messageId = null): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        if ($messageId) {
            $queryParamsMap[] = ['key' => 'message_id', 'value' => $messageId];
        }

        return $this->deleteApi('moderation/chat', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-vips
     */
    public function getVips(string $bearer, string $broadcasterId, array $users = [], int $first = null, string $after = null): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];

        foreach ($users as $user) {
            $queryParamsMap[] = ['key' => 'user_id', 'value' => $user];
        }

        if ($first) {
            $queryParamsMap[] = ['key' => 'first', 'value' => $first];
        }

        if ($after) {
            $queryParamsMap[] = ['key' => 'after', 'value' => $after];
        }

        return $this->getApi('channels/vips', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#add-channel-vip
     */
    public function addChannelVip(string $bearer, string $broadcasterId, string $userId): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];

        return $this->postApi('channels/vips', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#remove-channel-vip
     */
    public function removeChannelVip(string $bearer, string $broadcasterId, string $userId): ResponseInterface
    {
        $queryParamsMap = [];

        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'user_id', 'value' => $userId];

        return $this->deleteApi('channels/vips', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#get-shield-mode-status
     */
    public function getShieldModeStatus(string $bearer, string $broadcasterId, string $moderatorId): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        return $this->getApi('moderation/shield_mode', $bearer, $queryParamsMap);
    }

    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference#update-shield-mode-status
     */
    public function updateShieldModeStatus(string $bearer, string $broadcasterId, string $moderatorId, bool $isActive): ResponseInterface
    {
        $queryParamsMap = [];
        $queryParamsMap[] = ['key' => 'broadcaster_id', 'value' => $broadcasterId];
        $queryParamsMap[] = ['key' => 'moderator_id', 'value' => $moderatorId];

        $bodyParamsMap = [];
        $bodyParamsMap[] = ['key' => 'is_active', 'value' => $isActive];

        return $this->putApi('moderation/shield_mode', $bearer, $queryParamsMap, $bodyParamsMap);
    }
}
