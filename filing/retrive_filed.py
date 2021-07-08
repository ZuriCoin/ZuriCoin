import requests
import random
from hashlib import sha256

def SHA256(text):
    return sha256(text.encode('ascii')).hexdigest()

class turnfile2Zuri:
    def __init__(self):
        self.transaction = input("Enter the Transaction Hash: ")
        self.collector_value = input("Please, Enter the collector Value: ")
        self.amt = input("Enter the Amount: ")
        self.receiver_address = input("Receivers wallet Address: ")
        self.senders_address = ""
        self.previous_hash = ""
        self.nonce = random.randint(100, 200)
        self.transaction_de_detols = ""
        self.dotheFirstHash()
        

    def getotherTransDetails(self):
        out = ""
        coinDet = requests.get("http://localhost/Zuri Coin/Waziri_Coin/get_file_trans.php?\
            old_transaction={}&\
            amount={}&\
            echo={}".format(self.transaction, self.amt, "true")
        )
        print(coinDet.text)
        if coinDet.text is not "":
            out = dict(coinDet.json())
            #print(out)
            if (out.get("status") == "true"):
                print("enter here")

        return out
            
    def dotheFirstHash(self):
        othervalue = self.getotherTransDetails()
        if othervalue is not "":
            self.senders_address = othervalue.get("sender_address")
            previous_all = othervalue.get("previous_hash")
            self.previous_hash = str(previous_all).split("#WAZIRI#")[0]
            if (str(self.amt) is not str(othervalue.get("amount"))):
                print("The Amount Values entered are different.")
            if self.previous_hash == "":
                print("The previous Hash should contain some value.")
            print(str(self.nonce) + "->" + self.senders_address + "->" + self.receiver_address + "->" + str(float(self.amt)) + "->" + str(self.previous_hash))
            self.transaction_de_detols = SHA256(str(self.nonce) + "->" + self.senders_address + "->" + self.receiver_address +  "->" + str(float(self.amt)) + "->" + str(self.previous_hash))
            self.itHappens()


    def itHappens(self):
        #this is where the filed coin would be changed to a pending transaction
        x_data = requests.get("http://localhost/Zuri Coin/Waziri_Coin/_transrecorder_file.php?\
            ra={}&\
            transaction={}&\
            old_transaction={}&\
            filed_value={}&\
            amt={}".format(self.receiver_address, self.transaction_de_detols, self.transaction, self.collector_value, self.amt, )
        )
        print(x_data.text)
        if(x_data is not ""):
            bringer = x_data.json()
            if (bringer.get("status") is "true"):
                print("Initialized the Retrieve process of the filed coin.")

turnfile2Zuri()