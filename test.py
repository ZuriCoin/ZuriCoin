""" the = input("Enter some text")

print(the)
print(str(the))
print(float(the)) """

""" import zlib
hashed = hex(zlib.crc32(b'hello-world') % 2**32)

print(hashed) """

import hashlib
#hash_v = hashlib.sha512(b'30819f300d06092a864886f70d010101050003818d0030818902818100d25cc1172e77f98820e86ed5e1b4f4e2b83c9692a33e94a29aab5aed54cc65493cc332cfcc95fbede4858fb4ac33449ca4c6ef3881b78f6602865aa98b8737c01349c0024749df2461afd43362a450c2c0ef693b79d9c7efe8b2577df60aa8f5337d0dc7e45227e9db0173bf1ced6b46122ec36b626aa8d05ef3f5fa347ebcdb0203010001').hexdigest()

value = "30819f300d06092a864886f70d010101050003818d0030818902818100d25cc1172e77f98820e86ed5e1b4f4e2b83c9692a33e94a29aab5aed54cc65493cc332cfcc95fbede4858fb4ac33449ca4c6ef3881b78f6602865aa98b8737c01349c0024749df2461afd43362a450c2c0ef693b79d9c7efe8b2577df60aa8f5337d0dc7e45227e9db0173bf1ced6b46122ec36b626aa8d05ef3f5fa347ebcdb0203010001"
hash_v = hashlib.sha512(value.encode('ascii')).hexdigest()
print(hash_v)


def reducer(hashed):
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
print(reducer(hash_v))

#6aeefc29122a3962c90ef834f6caad0033bffcd62941b7a6205a695cc39e2767db7778a7ad76d173a083b9e14b210dc0212923f481b285c784ab1fe340d7ff4d

""" 
148->
Zuri58533707f29839a2d38cf79361d75cf13713344f9b074f7dd40f8421e4->
120.0->
$2y$10$l9H2s.4yp0OdD80VzXpejedBRwRxntj0GEC/tHy7l7sIFCoxp.1wS

126->
Zuri58533707f29839a2d38cf79361d75cf13713344f9b074f7dd40f8421e4->
Zuri45601107f29839a2d38cf79361d75cf13713344f9b074f7dd40f8421e4->
120.0->
$2y$10$l9H2s.4yp0OdD80VzXpejedBRwRxntj0GEC/tHy7l7sIFCoxp.1wS """