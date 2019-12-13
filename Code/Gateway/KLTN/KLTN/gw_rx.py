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
    print ("done in")
    def on_rx_done(self):
        print '----------------------------------'
        self.clear_irq_flags(RxDone=1)
        payload = self.read_payload(nocheck=True)
    #print payload
        data = ''.join([chr(c) for c in payload])
        print "Time:", str(time.ctime())
        print data
    
    
    
    def start(self):
        print 'start to receive...'
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
lora.set_freq(433)
lora.set_spreading_factor(7)  # 7-12
lora.set_bw(7)  # 0-9 
lora.set_coding_rate(1)  # 1-4         
lora.clear_irq_flags(RxDone=1)
print(lora)

try: 
    lora.start()
    
finally:
    lora.set_mode(MODE.SLEEP)
    BOARD.teardown()                    
    print "exit()"