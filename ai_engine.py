import json
import sys

data = sys.stdin.read()
user = json.loads(data)

skin_type = user["skin_type"]
concerns = user["concerns"]

response = ""

if skin_type == "oily":
    response += "Use salicylic acid, niacinamide, clay mask. "
elif skin_type == "dry":
    response += "Use hyaluronic acid, ceramides, gentle moisturizers. "
elif skin_type == "combination":
    response += "Use niacinamide + lightweight moisturizer. "
else:
    response += "Use sunscreen & gentle cleanser. "

if "acne" in concerns.lower():
    response += "Also add benzoyl peroxide for acne. "

print(json.dumps({"advice": response}))
