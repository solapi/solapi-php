<?php

namespace Nurigo\Solapi\Models\Fax;

class FaxOption {
    /**
     * @var string[] SOLAPI Storage API를 통해 FAX 파일을 업로드 한 후 생성되는 fileId를 해당 프로퍼티에 넣어야 합니다.
     */
    public $fileIds;
}
