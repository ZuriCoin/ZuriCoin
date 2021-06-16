"""
    When ever a wallet is created, two keys are generated,
    the public key and the private key. The private key belongs
    to the user along and we can not hold or save the private key.
    the public key - we can store and it would be used when sending zuri coin
    to the user...
"""

import binascii
from uuid import uuid4

import Crypto.Random
import requests
from Crypto import Signature
from Crypto.Hash import SHA256
from Crypto.PublicKey import RSA
from Crypto.Signature import PKCS1_v1_5
from hashlib import sha256
from datetime import datetime

def SHA256(text):
    return sha256(text.encode('ascii')).hexdigest()

class Wallet:
    """Creates, loads and holds private and public keys. Manages transaction
    signing and verification."""

    def __init__(self):
        self.private_key = None
        self.public_key = None

    def create_keys(self):
        """Create a new pair of private and public keys."""

        private_key, public_key = self.generate_keys()
        self.private_key = private_key
        self.public_key = public_key

    def load_keys(self):
        """Loads the keys from the wallet.txt file into memory."""
        try:
            with open('wallet.txt', mode='r') as f:
                keys = f.readlines()
                public_key = keys[0][:-1].split(" ")[-1]
                private_key = keys[1].split(" ")[-1]
                self.public_key = public_key
                self.private_key = private_key
            return True
        except (IOError, IndexError):
            print('Loading wallet failed...')
            return False
    
    def print_keys(self):
        txt = open("wallet.txt", "r+", encoding='utf-8-sig')
        for i, lines in enumerate(txt):
            line = lines.strip("\n")
            print(line)

    def save_keys(self):

        if self.public_key and self.private_key:
            access_token = uuid4()
            """ url = "https://a1in1.com/Waziri_Coin/waziri_d_enter_walletor.php" \
                + "?pub={}&private={}&access={}".format(
                        self.public_key,
                        self.private_key,
                        access_token
                    ) """
            url = "http://localhost/Waziri_Coin/waziri_d_enter_walletor.php" \
                + "?pub={}&private={}&access={}".format(
                        self.public_key,
                        SHA256(self.private_key),
                        access_token
                )
            
            response = requests.get(url)
            #print(response.json())
            # and response.json()["status"] == "true"
            if response.status_code == 200:
                print('Saving wallet successful ')
            else:
                print('Saving wallet failed...')
            today = str(datetime.today().isoformat())
            with open('wallet.txt',  mode='a') as f:
                f.write(today + "\n")
                f.write("Public Key: " + self.public_key + "\n")
                f.write("Private Key: " + self.private_key + "\n")
                print("Saving wallet Locally was Successful \n")
            """ try:
                today = str(date.today())
                with open('wallet.txt',  mode='a') as f:
                    f.write(today)
                    f.write("\n")
                    f.write("Public Key: " + self.public_key)
                    f.write('\n')
                    f.write("Private Key: " + self.private_key)
                    f.write('\n')
                    print("Saving wallet Locally was Successful \n")
            except:
                with open('wallet.txt',  mode='w') as f:
                    f.write("Public Key: " + self.public_key)
                    f.write('\n')
                    f.write("Private Key: " + self.private_key)
                    print("Saving wallet Locally was Successful \n")
            else:
                print('Saving wallet Locally failed...') """

    def generate_keys(self):
        """Generate a new pair of private and public key."""
        private_key = RSA.generate(1024, Crypto.Random.new().read)
        public_key = private_key.publickey()
        return (
            binascii
            .hexlify(private_key.exportKey(format='DER'))
            .decode('ascii'),
            binascii
            .hexlify(public_key.exportKey(format='DER'))
            .decode('ascii')
        )

    # def sign_transaction(self, sender, recipient, amount):
    #     """Sign a transaction and return the signature.

    #     Arguments:
    #         :sender: The sender of the transaction.
    #         :recipient: The recipient of the transaction.
    #         :amount: The amount of the transaction.
    #     """
    #     signer = PKCS1_v1_5.new(RSA.importKey(
    #         binascii.unhexlify(self.private_key)))
    #     h = SHA256.new((str(sender) + str(recipient) +
    #                     str(amount)).encode('utf8'))
    #     signature = signer.sign(h)
    #     return binascii.hexlify(signature).decode('ascii')

    # @staticmethod
    # def verify_transaction(transaction):
    #     """Verify the signature of a transaction.

    #     Arguments:
    #         :transaction: The transaction that should be verified.
    #     """
    #     public_key = RSA.importKey(binascii.unhexlify(transaction.sender))
    #     verifier = PKCS1_v1_5.new(public_key)
    #     h = SHA256.new((str(transaction.sender) + 
    #                     str(transaction.recipient) +
    #                     str(transaction.amount)).encode('utf8'))
    #     return verifier.verify(h, binascii.unhexlify(transaction.signature))


""" if __name__ == '__main__':
    wallet = Wallet()
    wallet.create_keys()
    wallet.save_keys()
    #wallet.load_keys() """
