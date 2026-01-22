<?php

namespace Nurigo\Solapi\Models\Kakao\Bms;

/**
 * BMS 비디오 정보 모델 (PREMIUM_VIDEO 타입용)
 *
 * videoUrl은 반드시 "https://tv.kakao.com/"으로 시작해야 합니다.
 * 유효하지 않은 동영상 URL 기입 시 발송 상태가 "그룹 정보를 찾을 수 없음" 오류로 표시됩니다.
 */
class BmsVideo
{
    /**
     * @var string 카카오TV 동영상 URL (필수, https://tv.kakao.com/으로 시작)
     */
    public $videoUrl;

    /**
     * @var string|null 썸네일 이미지 ID (선택)
     */
    public $imageId;

    /**
     * @var string|null 이미지 클릭 시 이동할 링크 (선택)
     */
    public $imageLink;

    /**
     * @return string
     */
    public function getVideoUrl(): string
    {
        return $this->videoUrl;
    }

    /**
     * @param string $videoUrl
     * @return BmsVideo
     */
    public function setVideoUrl(string $videoUrl): BmsVideo
    {
        $this->videoUrl = $videoUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageId(): ?string
    {
        return $this->imageId;
    }

    /**
     * @param string|null $imageId
     * @return BmsVideo
     */
    public function setImageId(?string $imageId): BmsVideo
    {
        $this->imageId = $imageId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    /**
     * @param string|null $imageLink
     * @return BmsVideo
     */
    public function setImageLink(?string $imageLink): BmsVideo
    {
        $this->imageLink = $imageLink;
        return $this;
    }
}
