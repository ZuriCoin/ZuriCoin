from hashlib import sha256

def SHA256(text):
    return sha256(text.encode('ascii')).hexdigest()

#this should be built like an API . where the values of the varables would be gotten via a POST request
class Block:
    def __init__ (self, count, senders_address, receivers_address, amount , previous_hash, nonce):
        #self.private_key = SHA256(input("Enter your private key: "))
        self.amount = amount
        self.receivers_address = receivers_address
        self.senders_address = senders_address
        self.previous_hash = previous_hash
        self.nonce = nonce
        #self._hash_area()
    
    def _hash_area(self):
        #self = str(self.nonce) + "->" + self.senders_address + "->" + self.receivers_address + "->" + str(self.amount) + "->" + str(self.previous_hash))
        text = str(self.nonce) + "->" + self.senders_address + "->" + self.receivers_address + "->" + str(float(self.amount)) + "->" + str(self.previous_hash)
        self.transaction_de_detols = SHA256(text)
        #print(new_hash)
        return self.transaction_de_detols

""" if __name__ =='__main__':
    count = 1
    previous_hash = ""
    transactions = '''Dhaval->Bhavin->20, Mando->Cara->45'''
    nonce = 3431470
    start = time.time()
    start_date = "03/06/2021"

    print(start)
    print(start_date)
    Block(count, transactions, previous_hash, start, start_date, nonce) """