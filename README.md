# SOLAPI PHP

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## Introduction

- PHP용 솔라피 SDK
- PHP 5.6 이상 호환

## 주의사항

- 반드시 php 내 curl, json extension 등이 설치되어 있는지 확인해주세요.

## 각 예제 폴더 별 안내사항

### 문자 발송 관련 예제 파일들

```
examples/sms/send_sms.php                              단문 문자 발송 예제
examples/sms/send_lms.php                              장문 문자 발송 예제
examples/sms/send_mms.php                              사진 문자 발송 예제
examples/sms/set_scheduled_messages.php                메시지 예약 발송 예제
examples/sms/send_send_versea.php                      해외 문자(SMS Only) 발송 예제
examples/sms/send_messages_with_auto_type_detect.php   문자 유형 감지 발송 예제  
```

### 카카오 메시지(알림톡, 친구톡) 발송 관련 예제 파일들

```
examples/kakaotalk/send_alimtalk.php           알림톡 발송 예제
examples/kakaotalk/send_chingutalk.php         친구톡 발송 예제
examples/kakaotalk/send_chingutalk_button.php  친구톡 버튼 발송 예제
examples/kakaotalk/send_chingutalk_image.php   이미지가 포함된 친구톡 발송 예제
```

### 그룹 발송 예제 파일들

```
examples/group_message/group_create.php            그룹 생성
examples/group_message/group_get_info.php          그룹 정보 조회
examples/group_message/group_delete.php            그룹 삭제
examples/group_message/group_get_list.php          그룹 목록 조회
examples/group_message/group_add_messages.php      그룹 메시지 추가
examples/group_message/group_delete_messages.php   그룹 메시지 삭제
examples/group_message/group_get_messages.php      그룹 메시지 조회
examples/group_message/group_send_messages.php     그룹 메시지 전송(종합 예제)
examples/group_message/set_reservation_group.php   그룹 예약설정
```

### 발송내역 조회 관련 예제 파일들

```
exmaples/message_list/simple_list.php         기본 예제
exmaples/message_list/print_details.php       메시지 상세 항목 출력
exmaples/message_list/search_date.php         날짜 검색
exmaples/message_list/search_messageId.php    메시지아이디 검색
exmaples/message_list/search_groupId.php      그룹아이디 검색
exmaples/message_list/search_status.php       상태코드 검색
exmaples/message_list/search_to.php           수신번호 검색
exmaples/message_list/pagination.php          페이지 처리
```

### 발신번호 인증/생성 관련 예제 파일들

```
examples/senderid/create_number.php      발신번호 생성 예제(STEP 1)
examples/senderid/request_voicecall.php  전화번호 인증(ARS) 예제(STEP 2)
examples/senderid/verify_token.php       ARS 인증번호 확인 예제(STEP 3)
examples/senderid/active_numbers.php     활성화 된 발신번호 리스트 조회 예제
```

### 카카오 채널/템플릿 조회 관련 예제 목록

```
examples/kakaotalk_channels(디렉토리)  카카오 비즈니스 채널 조회 관련 예제 포함
examples/kakaotalk_templates(디렉토리) 카카오 알림톡 템플릿 조회 관련 예제 포함
```

### 네이버 톡톡 발송 예제

```
examples/naver/send_naver.php            네이버톡톡(스마트알림) 발송(버튼 포함) 예제
````

### RCS 발송 예제 목록

```
examples/rcs(디렉토리) RCS SMS/LMS/MMS(s3, s6)/TPL(템플릿) 발송 예제 포함
```

### 기타

```
examples/statistics/statistics.php    통계 조회 예제
examples/get_balance.php              잔액 조회 예제
```

## License

MIT License(https://opensource.org/licenses/MIT)



