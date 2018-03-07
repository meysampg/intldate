<?php

class IntlDateTest extends \PHPUnit\Framework\TestCase
{
    // mocked object contains intldate trait
    protected $intldate;

    public function testItShouldGetAnTimestampAndReturnTrueGregorianDateTime()
    {
        $intldate = $this->intldate;

        $now = 1499057157; // Monday, July 3, 2017 4:45:57 AM
        $expected = '2017/07/03, 04:45:57';
        $actual = $intldate->fromTimestamp($now)->toGregorian()->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimestampAndReturnTruePersianDateTime()
    {
        $intldate = $this->intldate;

        $now = 1499057157; // Monday, July 3, 2017 4:45:57 AM
        $expected = '1396/04/12, 04:45:57';
        $actual = $intldate->fromTimestamp($now)->toPersian('en')->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimezonedTimestampAndReturnTruePersianDateTime()
    {
        $intldate = $this->intldate;

        $now = 1499073357; // Monday, July 3, 2017 9:15:57 AM
        $tz = 'Asia/Tehran';
        $expected = '1396/04/12, 04:45:57';
        $actual = $intldate->fromTimestamp($now, $tz)->toPersian('en')->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimestampAndReturnTruePersianTimezonedDateTime()
    {
        $intldate = $this->intldate;

        $now = 1499057157; // Monday, July 3, 2017 4:45:57 AM
        $tz = 'Asia/Tehran';
        $expected = '1396/04/12, 09:15:57';
        $actual = $intldate->fromTimestamp($now)->toPersian('en', $tz)->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnGregorianDateTimeAndReturnTrueTimestamp()
    {
        $intldate = $this->intldate;

        $now = [2017, 07, 03, 04, 45, 57];
        $expected = 1499057157; // Monday, July 3, 2017 4:45:57 AM
        $actual = $intldate->fromGregorian($now)->asTimestamp();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnPersianDateTimeAndReturnTrueTimestamp()
    {
        $intldate = $this->intldate;

        $now = [1396, 04, 12, 04, 45, 57];
        $expected = 1499057157; // Monday, July 3, 2017 4:45:57 AM
        $actual = $intldate->fromPersian($now)->asTimestamp();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnGregorianDateTimeAndReturnATimezonedPersianDateTime()
    {
        $intldate = $this->intldate;

        $now = [2017, 07, 03, 04, 45, 57];
        $expected = '1396/04/12, 09:15:57';
        $tz = 'Asia/Tehran';
        $actual = $intldate->fromGregorian($now)->toPersian('en', $tz)->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimezonedGregorianDateTimeAndReturnAPersianDateTime()
    {
        $intldate = $this->intldate;

        $now = [2017, 07, 03, 9, 15, 57];
        $expected = '1396/04/12, 04:45:57';
        $tz = 'Asia/Tehran';
        $actual = $intldate->fromGregorian($now, 'en', $tz)->toPersian('en')->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimezonedGregorianDateTimeAndReturnATimezonedPersianDateTime()
    {
        $intldate = $this->intldate;

        $now = [2017, 07, 03, 7, 15, 57];
        $expected = '1396/04/12, 04:45:57';
        $fromTz = 'Asia/Tehran';
        $toTz = 'Europe/Amsterdam';
        $actual = $intldate->fromGregorian($now, 'en', $fromTz)->toPersian('en', $toTz)->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimezonedGregorianDateTimeAndReturnALocalePersianDateTime()
    {
        $intldate = $this->intldate;

        $now = [2017, 07, 03, 9, 15, 57];
        $expected = '۱۳۹۶/۰۴/۱۲, ۰۴:۴۵:۵۷';
        $tz = 'Asia/Tehran';
        $actual = $intldate->fromGregorian($now, 'en', $tz)->toPersian('fa')->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetADatetimeStringAndSplitItIntoAnArrayOfThatDatetimeString()
    {
        $intldate = $this->intldate;

        $given = '2016/01/22 11:43:24';
        $expected = [
            0 => 2016,
            1 => 0,
            2 => 22,
            3 => 11,
            4 => 43,
            5 => 24,
        ];
        $result = $intldate->guessDateTime($given);
        $this->assertEquals($expected, $result);

        $given = '2017/04/23 13:42:11';
        $expected = [
            0 => 2017,
            1 => 3,
            2 => 23,
            3 => 13,
            4 => 42,
            5 => 11,
        ];
        $result = $intldate->guessDateTime($given);
        $this->assertEquals($expected, $result);
    }

    public function testItShoudReturnMinusOneWhenInvalidMonthIsGiven()
    {
        $intldate = $this->intldate;

        $given = '2016/00/22 11:43:24';
        $result = $intldate->guessDateTime($given);
        $this->assertFalse($result);

        $given = '2016/14/22 11:43:24';
        $result = $intldate->guessDateTime($given);
        $this->assertFalse($result);
    }

    public function testItShoudReturnMinusOneWhenInvalidDayIsGiven()
    {
        $intldate = $this->intldate;

        $given = '2016/01/0 11:43:24';
        $result = $intldate->guessDateTime($given);
        $this->assertFalse($result);

        $given = '2016/04/33 11:43:24';
        $result = $intldate->guessDateTime($given);
        $this->assertFalse($result);
    }

    public function testItShoudReturnMinusOneWhenInvalidHourIsGiven()
    {
        $intldate = $this->intldate;

        $given = '2016/01/1 -1:43:24';
        $result = $intldate->guessDateTime($given);
        $this->assertFalse($result);

        $given = '2016/04/12 25:43:24';
        $result = $intldate->guessDateTime($given);
        $this->assertFalse($result);
    }

    public function testItShoudReturnMinusOneWhenInvalidMinuteIsGiven()
    {
        $intldate = $this->intldate;

        $given = '2016/01/1 2:-1:24';
        $result = $intldate->guessDateTime($given);
        $this->assertFalse($result);

        $given = '2016/04/12 12:61:24';
        $result = $intldate->guessDateTime($given);
        $this->assertFalse($result);
    }

    public function testItShoudReturnMinusOneWhenInvalidSecondIsGiven()
    {
        $intldate = $this->intldate;

        $given = '2016/01/1 12:43:-2';
        $result = $intldate->guessDateTime($given);
        $this->assertFalse($result);

        $given = '2016/04/12 15:43:62';
        $result = $intldate->guessDateTime($given);
        $this->assertFalse($result);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->intldate = $this->getMockForTrait('meysampg\intldate\IntlDateTrait');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->intldate = null;
    }
}
