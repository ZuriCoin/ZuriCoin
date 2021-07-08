import random
#from blocks.block_area import Block
import hashlib

def BLAKE2B_(text):
    return hashlib.blake2b(text.encode('ascii'), digest_size=16).hexdigest()

def BLAKE2B_token(text):
    return hashlib.blake2b(text.encode('ascii'), digest_size=10).hexdigest()

class Address_Creator:
    def __init__(self, access_token, pub_key):
        self.acc = access_token
        self.pub = pub_key

    def rand(self):
        picked = 0
        rand_len = 6
        for i in range(rand_len):
            picked = picked * 10
            picked = picked + random.randint(0, 9)
        if (picked is not 0 and self.pub is not "" and self.acc is not ""):
            return str("Zuri{}{}{}".format(str(picked), BLAKE2B_token(self.acc), BLAKE2B_(self.pub) ))
        else:
            return "Error: Unable to create the Wallet Address. Null, 0 or None Values be avoided"