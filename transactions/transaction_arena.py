# We have three stages/kinds of transactions.
# Pending transactions, Verified Transactions and Failed Transactions...
# When ever a user initializise a transaction, It would enter the pending list of transactions.
# Miners would verify the opperation by finding the nonce and checking if the hash are same.

#a hacker tries to bridge the blockchain and the miners can not verify the transactions, the transaction 
#enters the failed state.

#A database may be involved to store transactions and indicating their states.
import random
from hashlib import sha256
import requests

def SHA256(text):
    return sha256(text.encode('ascii')).hexdigest()

class Transactions:
    def __init__(self):
        self.private_key = SHA256(input("Enter your private key: "))
        self.amount = float(input("Enter the Amount: "))
        self.receivers_address = input("Enter Receivers Wallet Address: ")
        self.senders_address = input("Enter your own Wallet Address: ")
        self.previous_hash = self.get_the_previous_keys()
        print("Previous Transaction: {}".format(self.previous_hash))
        self.nonce = random.randint(100, 200)
        print(str(self.nonce) + "->" + self.senders_address + "->" + self.receivers_address + "->" + str(self.amount) + "->" + str(self.previous_hash))
        self.transaction_de_detols = SHA256(str(self.nonce) + "->" + self.senders_address + "->" + self.receivers_address +  "->" + str(self.amount) + "->" + str(self.previous_hash))
        self._arrange_trans()
        #self.get_the_previous_keys()

    def _arrange_trans(self):
        if not(self.transaction_de_detols == ""): 
            print("\n transaction looks ok, sending trans... \n ")
            self.add_this_trans()

    def add_this_trans(self):
        print(self.private_key)
        print(self.transaction_de_detols)
        print(self.nonce)
        x = requests.get("http://localhost/Zuri Coin/Waziri_Coin/_transrecorder.php?\
            private_key={}&\
            sender_address={}&\
            receiver_address={}&\
            previous_hash={}&\
            transaction={}&\
            amount={}".format(self.private_key, self.senders_address, self.receivers_address, self.previous_hash, self.transaction_de_detols, self.amount )
        )
        print(x.text)
        outor = dict(x.json())
        if(outor.get("status") == "true"):
            print("Transaction initiation was Complete.")
        

        #this is where we would send the transaction to the ledger....
        #we would be sending 7 things to the trasaction DB...
        # private_key, transaction_de_detols, amount, receivers_address, senders_address, nonce

    def get_the_previous_keys(self):
        x = requests.get("http://localhost/Zuri Coin/Waziri_Coin/get_previous_hash.php?echo=true")
        x = x.json()
        the_previous = ""
        try:
            """ if (x["status"] == "false" ):
                raise BaseException("Could not connect get the previous Hash")
            elif (x["status"] == "true"):
                the_previous = x["transaction"]["transaction"] """
            if (x["status"] == "true" and x["transaction"] is not "" ):
                the_previous = x["transaction"]["transaction"]
        except:
            the_previous = ""

        #print(the_previous)
        """ 
        url = "http://localhost/Zuri Coin/Waziri_Coin/get_previous_hash.php"
        thobj = {"somekey": "somevalue"}
        x = requests.post(url, data = thobj)
        x = requests.post(url = url)
        print(x) """
        #print(the_previous)
        return the_previous


#Transactions()
