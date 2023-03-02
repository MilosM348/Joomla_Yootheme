<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\ko_KR;

class Person extends \Faker\Provider\Person
{
    /**
     * This provider uses wikipedia's top Korean last names. These cover more than 90% of Korean population.
     */

    protected static $maleNameFormats = array(
        '{{lastName}}{{firstNameMale}}',
    );

    protected static $femaleNameFormats = array(
        '{{lastName}}{{firstNameFemale}}',
    );

    /**
     * {@link} http://ko.wikipedia.org/wiki/%ED%95%9C%EA%B5%AD%EC%9D%98_%EC%84%B1%EC%94%A8%EC%99%80_%EC%9D%B4%EB%A6%84#.EC.8B.9C.EB.8C.80.EB.B3.84_.EA.B0.80.EC.9E.A5_.ED.9D.94.ED.95.9C_.EC.9D.B4.EB.A6.84_10.EC.84.A0.28.E9.81.B8.29
     */
    protected static $firstNameMale = array(
        '건우', '건호', '경석', '경수', '경춘', '경환', '광수', '광현', '구범', '규산', '기수', '남수', '남호', '대선', '대수', '도윤',
        '도현', '동윤', '동하', '동현', '명식', '명호', '문용', '문창', '민석', '민성', '민수', '민재', '민준', '민철', '민환', '병철',
        '병호', '상선', '상수', '상우', '상욱', '상준', '상철', '상현', '상호', '상훈', '서준', '서호', '선엽', '성곤', '성령', '성민',
        '성수', '성진', '성현', '성호', '성훈', '수원', '승민', '승현', '승호', '시우', '영길', '영수', '영식', '영일', '영진', '영철',
        '영하', '영호', '영환', '예준', '용태', '용환', '용훈', '우진', '원준', '원진', '원희', '은성', '은택', '인규', '재윤', '재철',
        '재혁', '재현', '재호', '재훈', '정남', '정수', '정식', '정웅', '정호', '정훈', '종수', '종주', '종훈', '주원', '주형', '준',
        '준범', '준서', '준영', '준혁', '준형', '준호', '중수', '지후', '지훈', '진수', '진우', '진호', '창용', '채현', '태현', '태호',
        '혁상', '현규', '현우', '현종', '현준', '형민', '형철', '호민', '호진', '홍선', '효일',
    );

    protected static $firstNameFemale = array(
        '가람', '강은', '강희', '경은', '경주', '근영', '기연', '나루', '나리', '나연', '나은', '나형', '누리', '다영', '도연', '동현',
        '미경', '미라', '미란', '미영', '미정', '민서', '민아', '민지', '민형', '민희', '반희', '보람', '보미', '보민', '봄', '상명',
        '새미', '서연', '서영', '서윤', '서현', '선영', '선우', '선정', '선호', '성미', '성민', '성은', '세원', '소민', '소연', '소영',
        '소정', '수란', '수민', '수빈', '수연', '수원', '수정', '수진', '순항', '슬기', '시은', '신애', '아름', '아린', '여진', '연선',
        '연희', '영진', '영화', '예원', '예은', '예지', '예진', '유리', '유정', '유진', '윤경', '윤미', '윤서', '윤영', '은경', '은미',
        '은상', '은서', '은애', '은영', '은정', '은주', '은지', '은진', '은형', '은혜', '은희', '인화', '재연', '정란', '정민', '정은',
        '정화', '주명', '주미', '주연', '주희', '지민', '지선', '지숙', '지아', '지연', '지영', '지예', '지우', '지원', '지은', '지현',
        '지혜', '지희', '진아', '진희', '채원', '태희', '하나', '하윤', '하은', '한나', '헤선', '현영', '현정', '현주', '현지', '혜나',
        '혜림', '혜민', '혜숙', '혜연', '혜진', '효진', '희경', '희원',
    );

    /**
     * {@link} http://ko.wikipedia.org/wiki/%EB%8C%80%ED%95%9C%EB%AF%BC%EA%B5%AD%EC%9D%98_%EC%9D%B8%EA%B5%AC%EC%88%9C_%EC%84%B1%EC%94%A8_%EB%AA%A9%EB%A1%9D
     */
    protected static $lastName = array(
        '김', '이', '박', '최', '정', '강', '조', '윤', '장', '임', '오', '한', '신', '서', '권', '황', '안', '송', '류', '홍',
        '전', '고', '문', '손', '양', '배', '조', '백', '허', '남', '심', '유', '노', '하', '전', '정', '곽', '성', '차', '유',
        '구', '우', '주', '임', '나', '신', '민', '진', '지', '엄', '원', '채', '강', '천', '양', '공', '현', '방', '변', '함',
        '노', '염', '여', '추', '변', '도', '석', '신', '소', '선', '주', '설', '방', '마', '정', '길', '위', '연', '표', '명',
        '기', '금', '왕', '반', '옥', '육', '진', '인', '맹', '제', '탁', '모', '남궁', '여', '장', '어', '유', '국', '은', '편',
    );
}
