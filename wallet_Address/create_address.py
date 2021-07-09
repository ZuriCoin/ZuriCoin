import random
#from blocks.block_area import Block
import hashlib

""" def BLAKE2B_(text):
    return hashlib.blake2b(text.encode('ascii'), digest_size=16).hexdigest() """
#using this instead of the blake above for the public key...
def SHA512(value):
    return hashlib.sha512(value.encode('ascii')).hexdigest()

def BLAKE2B_token(text):
    return hashlib.blake2b(text.encode('ascii'), digest_size=10).hexdigest()

def reducer(hashed):
    if len(hashed) > 3:
        ans = ""
        for i, s in enumerate(hashed):
            if i % 2 is 0:
                ans = ans + s
        ans2 = ""
        #print(ans)
        for i, s in enumerate(ans):
            if i % 2 is not 0:
                ans2 = ans2 + s

    return ans2

""" def reducer(hashed):
    ans = ""
    for i, s in enumerate(hashed):
        if i % 2 is 0:
            ans = ans + s
    ans2 = ""
    #print(ans)
    for i, s in enumerate(ans):
        if i % 2 is not 0:
            ans2 = ans2 + s

    return ans2 """

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
            print(SHA512(self.pub))
            print(reducer(SHA512(self.pub)))
            return str("Zuri{}{}{}".format(str(picked), BLAKE2B_token(self.acc), reducer(SHA512(self.pub)) ))
        else:
            return "Error: Unable to create the Wallet Address. Null, 0 or None Values be avoided"


print(Address_Creator("952d99b9-66c5-4b63-9302-255b5f8f0d6e", "30819f300d06092a864886f70d010101050003818d0030818902818100d25cc1172e77f98820e86ed5e1b4f4e2b83c9692a33e94a29aab5aed54cc65493cc332cfcc95fbede4858fb4ac33449ca4c6ef3881b78f6602865aa98b8737c01349c0024749df2461afd43362a450c2c0ef693b79d9c7efe8b2577df60aa8f5337d0dc7e45227e9db0173bf1ced6b46122ec36b626aa8d05ef3f5fa347ebcdb0203010001").rand())
