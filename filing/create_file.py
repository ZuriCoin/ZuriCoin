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

class FileCoins:
    def __init__(self):
        self.private_key = SHA256(input("Enter your private key: "))
        self.amount = float(input("Enter the Amount: "))
        #self.receivers_address = input("Enter Receivers Wallet Address: ")
        self.senders_address = input("Enter your own Wallet Address: ")
        self.previous_hash = self.get_the_previous_keys()
        print("Previous Transaction: {}".format(self.previous_hash))
        self.nonce = random.randint(100, 200)
        print(str(self.nonce) + "->" + self.senders_address + "->" + str(self.amount) + "->" + str(self.previous_hash))
        self.transaction_de_detols = SHA256(str(self.nonce) + "->" + self.senders_address + "->" + str(self.amount) + "->" + str(self.previous_hash))
        self._arrange_files()
        #self.get_the_previous_keys()

    def _arrange_files(self):
        if not(self.transaction_de_detols == ""):
            print("\n transaction looks ok, sending trans... \n ")
            self.add_this_trans_file()

    def add_this_trans_file(self):
        print(self.private_key)
        print(self.transaction_de_detols)
        print(self.nonce)
        x = requests.get("http://localhost/Zuri Coin/Waziri_Coin/file_a_coin.php?\
            private_key={}&\
            sender_address={}&\
            previous_hash={}&\
            transaction={}&\
            amount={}".format(self.private_key, self.senders_address, self.previous_hash, self.transaction_de_detols, self.amount )
        )
        print(x.text)
        outter = dict(x.json())
        if (outter.get("status") == "true" ):
            if (outter.get("collector_value") is not ""):
                retrive_key = outter.get("collector_value")
                transac_ = outter.get("transaction")
                firm = input("Do you wish to save the file in different machines? type yes or no. Choose No for advanced security on the filed Coin: ")
                if "yes" in firm.lower():
                    the_file = open( str( str(self.amount)+ "Zuri" +self.transaction_de_detols), 'w')
                    the_file.write(str(retrive_key + "\n"))
                    the_file.write(str(transac_ + "\n"))
                    the_file.write(str(str(self.amount) + " ZuriCoin" +"\n"))
                    print("Coin saved for retrive")
        
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
        return the_previous


#FileCoins()
