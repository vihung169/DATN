import requests
from time import sleep
import time
import json
import packer
import sys
import numpy as np
sys.path.insert(0, '../../pySX127x')        
from SX127x.LoRa import *
from SX127x.board_config import BOARD


class LoRaRcvCont(LoRa):
    def __init__(self, verbose=False):
        super(LoRaRcvCont, self).__init__(verbose)
        self.set_mode(MODE.SLEEP)
        self._id = "GW_01"

    def on_rx_done(self):
	#nhan data tu endnode gui len
        print '----------------------------------'
        self.clear_irq_flags(RxDone=1)
        payload = self.read_payload(nocheck=True)
        data = ''.join([chr(c) for c in payload])
        print "Time:", str(time.ctime())
        #print "Rawinput:", payload

        try:
            _length, _data = packer.Unpack_Str(data)
            print "Time:", str(time.ctime())
            print "Length:", _length
            print "Receive:", _data
        except:
            print "Receive:", data
	    result = json.loads(data)
	#print result["user"]
	kq={'username':'admin','temp':result["temp"],'humi':result["humi"],'lux':result["lux"],'ph':result["ph"],'tds':result["tds"]}
	
        host = "http://iotsforhuman.com/API/ApiRecordData.php"
	
        r = requests.post(host,data=kq)	

        sleep(0.5)
        self.set_mode(MODE.SLEEP)
        self.reset_ptr_rx()
	
	#gui lenh xuong endnode
        self.set_mode(MODE.RXCONT)
	print '-------------------------------------------------------------------------------------'      

        self.set_mode(MODE.STDBY)
        self.clear_irq_flags(TxDone=1)
	
       	data = r.text
	controller = data[1:71]
	
	listtest=list()
	listtest=[]
	i=0
	for x in controller:
	    listtest.insert(i,ord(x))
	    i += 1
        print "Controller:", controller
        
        sleep(1)
        self.write_payload(listtest)                                       
        self.set_mode(MODE.TX)

        sleep(.5)
        self.set_mode(MODE.SLEEP)
        self.set_dio_mapping([0] * 6)
        sleep(.5)
        self.set_mode(MODE.STDBY)
        sleep(.5)
        self.reset_ptr_rx()
        self.set_mode(MODE.RXCONT)

	 #######
        sleep(10)
        #######
    def start(self):
	while True:
            
            print 'BAT DAU NHAN DU LIEU'
            self.reset_ptr_rx()
            self.set_mode(MODE.RXCONT)
            while True:	
                 sleep(.5)
	  
#
# initialize sx1278
# 
BOARD.setup()

lora = LoRaRcvCont()
lora.set_mode(MODE.STDBY)
lora.set_pa_config(pa_select=1)
lora.set_freq(434)
lora.set_spreading_factor(7)  # 7-12
lora.set_bw(7)  # 0-9 
lora.set_coding_rate(1)  # 1-4         
lora.clear_irq_flags(RxDone=1)
print("--------------------------------------------------------------------------")
print("----------------TRUONG DAI HOC CONG NGHIEP TP HCM-------------------------")
print("---------------------KHOA CONG NGHE DIEN TU-------------------------------")
print("----------------------KHOA LUAN TOT NGHIEP--------------------------------")
print("-------------------------VI THAI HUNG-------------------------------------")
print("--------------------------15086471----------------------------------------")
print("--------------------------------------------------------------------------")
print("------------------HE THONG BAT DAU HOAT DONG------------------------------")
print("--------------------------------------------------------------------------")
print("--------------------------------------------------------------------------")
print("-----------------------THIET BI GATEWAY-----------------------------------")
print("--------------------------------------------------------------------------")
try: 
    lora.start()
finally:
    lora.set_mode(MODE.SLEEP)
    BOARD.teardown()                    
    print "exit()"

