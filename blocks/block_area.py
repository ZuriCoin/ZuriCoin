from hashlib import sha256
import time

def SHA256(text):
    return sha256(text.encode('ascii')).hexdigest()

#this should be built like an API . where the values of the varables would be gotten via a POST request
class block:
    #this 
    def __init__ (self, count, transaction_, previous_hash, time_, date_, nonce):
        self.count = count
        #this would contain the public key to be sent to and the public key from which it is sent from
        self.transaction = transaction_
        #the hashed value of the previous key
        self.previous = previous_hash
        self.nonce = nonce
        self.time = time_
        self.date = date_
        self._hash_area()
    
    def _hash_area(self):
        text = str(self.count) + self.transaction + self.previous + str(self.nonce)
        new_hash = SHA256(text)
        print(new_hash)

if __name__ =='__main__':
    #you would always get the count from the database. if the last transaction was 0, the next would be 1.
    count = 1
    #previous hash would always be gotten from the database. since this is the firt block, it would be empty.
    previous_hash = ""
    #I am using people's names just for easy understnading else it is suppose to be a combination of the 
    # the wallets public key. Example - Zuri0b8404859485jNJ38jU3l432NJ4SN53K
    # public key = 0b8404859485jNJ38jU3l432NJ4SN53K
    #this values would be gotten in the header or via a POST request depending on the one that you prepfer...
    transactions = '''Dhaval->Bhavin->20, Mando->Cara->45'''
    #difficulty = 3
    nonce = 3431470
    start = time.time()
    start_date = "03/06/2021"

    print(start)
    print(start_date)
    block(count, transactions, previous_hash, start, start_date, nonce)