from transactions.transaction_arena import Transactions
from wallets.wallet_ import Wallet
import random
from blocks.block_area import Block
from mining.zuri_mine import Minable
import requests
import hashlib
#import "wallets/wallet.py"

def SHA256(text):
    return hashlib.sha256(text.encode('ascii')).hexdigest()

def BLAKE2B_(text):
    return hashlib.blake2b(text.encode('ascii'), digest_size=16).hexdigest()

def mine_side():
    minable_blocks = Minable()
    pending = minable_blocks.get_all()
    print("To mine you need to have a Zuri Wallet Address. You also need upto 100 Zuri coins in your Wallet.\
         This is to help the community understand that you have invested your financial resource on this project. Before tryiing to Mine.")
    reward_address = input("Where should the reward for mining Zuri be sent to? \n")
    for i in pending:
        print(i)
        for nonce in range(200):
            past_hash = i.get("previous_hash")
            previous_hash = ""
            if past_hash is not "#WAZIRI#":
                print(str(i.get("count")))
                previous_hash = past_hash.split("#WAZIRI#")[0]
            Tblock = Block(i.get("count"), i.get("sender_address"), i.get("receiver_address"), i.get("amount"), previous_hash, nonce)
            hashed = Tblock._hash_area()
            """ print(str(nonce) + "->" + i.get("sender_address") + "->" + i.get("receiver_address") + "->" + str(float(i.get("amount"))) + "->" + previous_hash )
            downtown = SHA256(str(nonce) + "->" + i.get("sender_address") + "->" + i.get("receiver_address") + "->" + str(float(i.get("amount"))) + "->" + previous_hash)
            print(downtown)  """
            ch = requests.get("http://localhost/Waziri_Coin/mining_leges.php?\
                miner_address={}&\
                block_count={}&\
                nonce={}&\
                transaction_py={}".format(reward_address, i.get("count"), nonce, hashed)
            )
            print(hashed)
            print(ch.text)
            if (ch.json()["status"] == "true"):
                print("GoodNews You have mined Zuri")
                break
        #print(i.get("count"))

print("1 to create your Zuri Wallet")
print("2 to send ZuriCoin")
print("3 to Receive a List of all your Possible wallet Addresses")
print("4 to see all/retrive all your Public Keys")
print("5 to mine Zuri Coin")
print("6 to Exit")
print("To back-up your wallets, you would need to save wallet.txt in the cloud or on an external disk drive.\n You can also write your keys on paper and store somewhere save.")


exit = 1

while(exit):
    #print(BLAKE2B_("Hello Dear"))
    #print(SHA256("Hello Dear"))
    x = input("Please Enter a Number from 1-6 as Described Above\n")
    if( x.isdigit() == True ):
        x = int(x)
        if (x == 1):
            wallet = Wallet()
            wallet.create_keys()
            wallet.save_keys()
            #wallet.load_keys()
        elif (x == 2):
            trans = Transactions()
        elif (x == 3):
            print("No wallet can have up to 1,000,000 addresses \n")
            print("Your Wallet Address would look like:")
            print("Zuri + Random(000000) + public_key_modified")
            print("So any random number within this range belongs to you.")
            print("You can manually create your own address as to receive Zuricoin.")
            pub_key_dat = input("Enter a public key \n")
            picked = 0
            for i in range(6):
                picked = picked * 10
                picked = picked + random.randint(0, 9)
            
            if (picked is not 0 ):
                print("one of your 999,999 Wallet Address is: Zuri{}{}".format(picked, BLAKE2B_(pub_key_dat) ))

        elif (x == 4):
            print("All Generated keys from Wallet.txt...\n")
            print("Please do not expose your private keys...\n")
            wallet = Wallet()
            wallet.print_keys()
        elif (x == 5):
            mine_side()
        elif( x == 6):
            exit = 0
    else:
        print("Only integers are allowed.")


