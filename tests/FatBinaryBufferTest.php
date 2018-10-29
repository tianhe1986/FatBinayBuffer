<?php

namespace FatBinaryBuffer\Tests;

use PHPUnit\Framework\TestCase;
use FatBinaryBuffer\FatBinaryBuffer;

class FatExcelTest extends TestCase
{
    protected $isSystemBigEndian;
    
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->isSystemBigEndian = (pack("S", 1) === pack("n", 1));
    }
    
    public function testUShort()
    {
        $a = 0x127;
        $binaryBufferBE = new FatBinaryBuffer(true);
        $binaryBufferLE = new FatBinaryBuffer(false);
        
        $binaryBufferBE->writeUShort($a);
        $this->assertEquals(2, $binaryBufferBE->getLength());
        $this->assertEquals(pack("n", $a), $binaryBufferBE->getBuffer());
        $this->assertEquals(0x1, ord($binaryBufferBE->getBuffer()[0]));
        $this->assertEquals(0x27, ord($binaryBufferBE->getBuffer()[1]));
        
        $binaryBufferLE->writeUShort($a);
        $this->assertEquals(2, $binaryBufferLE->getLength());
        $this->assertEquals(pack("v", $a), $binaryBufferLE->getBuffer());
        $this->assertEquals(0x27, ord($binaryBufferLE->getBuffer()[0]));
        $this->assertEquals(0x1, ord($binaryBufferLE->getBuffer()[1]));
        
        $binaryBufferBE->rewind();
        $binaryBufferLE->rewind();
        
        $this->assertEquals($a, $binaryBufferBE->readUShort());
        $this->assertEquals($a, $binaryBufferLE->readUShort());
    }
    
    public function testShort()
    {
        $a = 0x127;
        $binaryBufferBE = new FatBinaryBuffer(true);
        $binaryBufferLE = new FatBinaryBuffer(false);
        
        $packed = pack("s", $a);
        $binaryBufferBE->writeShort($a);
        $this->assertEquals(2, $binaryBufferBE->getLength());
        $this->assertEquals($this->isSystemBigEndian ? $packed : strrev($packed), $binaryBufferBE->getBuffer());
        $this->assertEquals(0x1, ord($binaryBufferBE->getBuffer()[0]));
        $this->assertEquals(0x27, ord($binaryBufferBE->getBuffer()[1]));
        
        $binaryBufferLE->writeShort($a);
        $this->assertEquals(2, $binaryBufferLE->getLength());
        $this->assertEquals($this->isSystemBigEndian ? strrev($packed) : $packed, $binaryBufferLE->getBuffer());
        $this->assertEquals(0x27, ord($binaryBufferLE->getBuffer()[0]));
        $this->assertEquals(0x1, ord($binaryBufferLE->getBuffer()[1]));
        
        $binaryBufferBE->rewind();
        $binaryBufferLE->rewind();
        
        $this->assertEquals($a, $binaryBufferBE->readShort());
        $this->assertEquals($a, $binaryBufferLE->readShort());
    }
    
    public function testUInt32()
    {
        $a = 0x123;
        $binaryBufferBE = new FatBinaryBuffer(true);
        $binaryBufferLE = new FatBinaryBuffer(false);
        
        $binaryBufferBE->writeUInt32($a);
        $this->assertEquals(4, $binaryBufferBE->getLength());
        $this->assertEquals(pack("N", $a), $binaryBufferBE->getBuffer());
        $this->assertEquals(0x23, ord($binaryBufferBE->getBuffer()[3]));
        
        $binaryBufferLE->writeUInt32($a);
        $this->assertEquals(4, $binaryBufferLE->getLength());
        $this->assertEquals(pack("V", $a), $binaryBufferLE->getBuffer());
        $this->assertEquals(0x23, ord($binaryBufferLE->getBuffer()[0]));
        
        $binaryBufferBE->rewind();
        $binaryBufferLE->rewind();
        
        $this->assertEquals($a, $binaryBufferBE->readUInt32());
        $this->assertEquals($a, $binaryBufferLE->readUInt32());
    }
    
    public function testInt32()
    {
        $a = 0x123;
        $binaryBufferBE = new FatBinaryBuffer(true);
        $binaryBufferLE = new FatBinaryBuffer(false);
        
        $packed = pack("l", $a);
        $binaryBufferBE->writeInt32($a);
        $this->assertEquals(4, $binaryBufferBE->getLength());
        $this->assertEquals($this->isSystemBigEndian ? $packed : strrev($packed), $binaryBufferBE->getBuffer());
        $this->assertEquals(0x23, ord($binaryBufferBE->getBuffer()[3]));
        
        $binaryBufferLE->writeInt32($a);
        $this->assertEquals(4, $binaryBufferLE->getLength());
        $this->assertEquals($this->isSystemBigEndian ? strrev($packed) : $packed, $binaryBufferLE->getBuffer());
        $this->assertEquals(0x23, ord($binaryBufferLE->getBuffer()[0]));
        
        $binaryBufferBE->rewind();
        $binaryBufferLE->rewind();
        
        $this->assertEquals($a, $binaryBufferBE->readInt32());
        $this->assertEquals($a, $binaryBufferLE->readInt32());
    }
    
    public function testUInt64()
    {
        $a = 0x123456;
        $binaryBufferBE = new FatBinaryBuffer(true);
        $binaryBufferLE = new FatBinaryBuffer(false);
        
        $binaryBufferBE->writeUInt64($a);
        $this->assertEquals(8, $binaryBufferBE->getLength());
        $this->assertEquals(pack("J", $a), $binaryBufferBE->getBuffer());
        
        $binaryBufferLE->writeUInt64($a);
        $this->assertEquals(8, $binaryBufferLE->getLength());
        $this->assertEquals(pack("P", $a), $binaryBufferLE->getBuffer());
        
        $binaryBufferBE->rewind();
        $binaryBufferLE->rewind();
        
        $this->assertEquals($a, $binaryBufferBE->readUInt64());
        $this->assertEquals($a, $binaryBufferLE->readUInt64());
    }
    
    public function testInt64()
    {
        $a = 0x123456;
        $binaryBufferBE = new FatBinaryBuffer(true);
        $binaryBufferLE = new FatBinaryBuffer(false);
        
        $packed = pack("q", $a);
        $binaryBufferBE->writeInt64($a);
        $this->assertEquals(8, $binaryBufferBE->getLength());
        $this->assertEquals($this->isSystemBigEndian ? $packed : strrev($packed), $binaryBufferBE->getBuffer());
        
        $binaryBufferLE->writeInt64($a);
        $this->assertEquals(8, $binaryBufferLE->getLength());
        $this->assertEquals($this->isSystemBigEndian ? strrev($packed) : $packed, $binaryBufferLE->getBuffer());
        
        $binaryBufferBE->rewind();
        $binaryBufferLE->rewind();
        
        $this->assertEquals($a, $binaryBufferBE->readInt64());
        $this->assertEquals($a, $binaryBufferLE->readInt64());
    }
    
    public function testMixedBigEndian()
    {
        
    }
    
    public function testMixedLittleEndian()
    {
        
    }
}
