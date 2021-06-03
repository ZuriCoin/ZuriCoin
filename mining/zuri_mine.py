from hashlib import sha256
import time

MAX_NONCE = 10000000
def SHA256(text):
    return sha256(text.encode('ascii')).hexdigest()

def mine(block_number, transactions, previous_hash, prefix_zeros):
    prefix_str = '0'*prefix_zeros

    for nonce in range(MAX_NONCE):
        text = str(block_number) + transactions + previous_hash + str(nonce)
        new_hash = SHA256(text)
        if new_hash.startswith(prefix_str):
            print(f"Successfully mined Zuri... nonce value: {nonce}. ")
            return new_hash

    raise BaseException(f"Could not find the correct after trying Max Nonce: {MAX_NONCE} times")

if __name__ =='__main__':
    transactions = '''Dhaval->Bhavin->20, Mando->Cara->45'''
    difficulty = 5
    start = time.time()
    new_hash = mine(1, transactions, "", difficulty)
    print(new_hash)
    total_time = str( time.time() - start )
    print(f"It took about {total_time}")
