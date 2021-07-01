import requests
class turnfile2Zuri:
    def __init__(self):
        self.transaction = input("Enter the Transaction Hash: ")
        self.collector_value = input("Please, Enter the collector Value: ")
        self.amt = input("Enter the Amount: ")

    def getotherTransDetails(self):
        pass
    def dotheFirstHash(self):
        pass
    def itHappens(self):
        #this is where the filed coin would be changed to a pending transaction
        x = requests.get("https://a1in1.com/Waziri_Coin/file_a_coin.php?\
            private_key={}&\
            sender_address={}&\
            previous_hash={}&\
            transaction={}&\
            amount={}".format(self.private_key, self.senders_address, self.previous_hash, self.transaction_de_detols, self.amount )
        )
        pass