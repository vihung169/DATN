#!/usr/bin/env python

from time import sleep
import json
import packer
import time
import sys
sys.path.insert(0, '../../pySX127x')        
from SX127x.LoRa import *
from SX127x.board_config import BOARD

class LoRaBeacon(LoRa):
    def __init__(self, verbose=False):
        super(LoRaBeacon, self).__init__(verbose)
        self.set_mode(MODE.SLEEP)
        self._id = "NODE_01"
        self.rx_done = False

    def on_rx_timeout(self):
        print("\non_RxTimeout")
        print(self.get_irq_flags())

    def on_rx_done(self):
        self.clear_irq_flags(RxDone=1)
        payload = self.read_payload(nocheck=True)
        data = ''.join([chr(c) for c in payload])

        if data is not None and len(data):
            try:
                _length, _data = packer.Unpack_Str(data)
                print "Time:", str(time.ctime()) 
                print "Rawinput:", payload
                print "Receive:", _data
            except:
 
                print "Receive:", data 

        self.set_mode(MODE.SLEEP)
        #self.reset_ptr_rx()
        #self.set_mode(MODE.RXCONT)
        self.rx_done = True


    def start(self):
        while True:
            print '----------------------------------'      

            self.set_mode(MODE.STDBY)
            self.clear_irq_flags(TxDone=1)

            data = "hello"
	    listtest=list()
	    listtest=[]
	    i=0
	    for x in data:
		listtest.insert(i,ord(x))
		i += 1
		#dong goi data
            #_length, _payload = packer.Pack_Str(data)
	    #print _payload
		#chuyen doi data thanh ma ord
            #data = [int(hex(ord(c)), 0) for c in _payload]
		
            print "data", listtest
            print "Raw:", data

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

            for _ in range(t):
               sleep(.1)

               if self.rx_done == True:
                  self.rx_done = False
                  break

  
BOARD.setup()

sf = 7
bw = 7
cr = 1
t = sf * bw * cr

lora = LoRaBeacon()
lora.set_mode(MODE.SLEEP)
lora.set_pa_config(pa_select=1)
lora.set_freq(433)
lora.set_spreading_factor(sf)  # 7-12
lora.set_bw(bw)  # 0-9
lora.set_coding_rate(cr)  # 1-4
lora.clear_irq_flags(TxDone=1)
#print(lora)

try:
    lora.start()
finally:
    lora.set_mode(MODE.SLEEP)
    BOARD.teardown()
    print "exit()"
