import requests

class wallet_balance:
    def __init__(self, wallet_address):
        self.wallet_address = wallet_address
        self.status = "VALID ALL"
        self.get_balance()
    def get_balance(self):
        x = requests.get("https://a1in1.com/Zuri Coin/Waziri_Coin/get_balance.php?\
            wallet_address={}&\
            status={}".format(self.wallet_address, self.status)
        )

        out = x.text
        print(out)
        if out is not "":
            outor = dict(x.json())
            if(outor.get("status") == "true"):
                print("You balance is: {}".format(outor.get("amount"))  )

#wallet_balance("Zuri327592fdc525166aee28cd6bad2af5702a6c6002d792cbc3f47bbea041")