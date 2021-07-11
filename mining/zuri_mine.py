from hashlib import sha256
import requests

class Minable:
    def get_all(self):
        g = requests.get("https://a1in1.com/Zuri Coin/Waziri_Coin/get_trans_by_.php?status=PENDING")
        the_pending = list(g.json())
        return the_pending
