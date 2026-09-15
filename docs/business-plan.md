# Wiener Box: business and launch plan

**Working draft · 15 September 2026 · All financial amounts in Australian dollars**

**Implementation update:** Laravel/Lunar is the selected backend. A local storefront and native admin are implemented. Financial outputs below retain the original scenario and require a Stripe/Cloud reforecast before funding decisions.

## 1. Recommendation

Launch a tightly controlled Sydney delivery pilot selling German-style sausage boxes, with a monthly subscription as the main product, a one-off gift box, and a small range of individually selectable packs. Build the customer experience in Laravel and Vue on Laravel Cloud. The founder has selected a fully Laravel commerce backend: Lunar for catalogue, carts, orders and admin, Laravel accounts, and Stripe/Cashier for payment and recurring-billing integration. Extend the native admin for chilled-food operations. See the updated commerce blueprint for implementation status and the work still required.

The proposition is **“Serious sausage. Silly name.”** Customers get a useful amount of good sausage, a clear explanation of what is inside, cooking ideas, a dependable delivery, and a brand they enjoy gifting. Curation, convenience and service must justify buying through Wiener Box when the supplier also sells directly.

**Proceed first with validation. Commercial viability is not yet established.** The business needs a wholesale agreement, proven delivery economics and repeat paid demand. Do not commit to nationwide shipping, custom packaging minimums or a large software build before those three conditions are demonstrated.

### Decisions proposed for the pilot

| Decision | Starting position | Evidence needed to change it |
|---|---|---|
| Launch area | Selected Sydney postcodes | Carrier service map, trial results and profitable delivery quotes |
| Supplier | German Butchery as preferred lead supplier | Written wholesale and fulfilment terms |
| Handling | Supplier-sealed packs, assembled by an appropriately approved operator | Food-business classification and handling plan |
| Range | One subscription size, one gift box, 6–8 individual sausage packs, 2–3 pantry additions | Paid purchase and repeat behaviour |
| Recurrence | Calendar-month subscription, with skip/pause/cancel | Customer demand and app capability test |
| Delivery | One or two scheduled runs a week, only validated lanes | Density and service performance |
| Commerce | Laravel/Vue, Lunar admin and Stripe/Cashier | Test-mode checkout, recurring-order and postcode enforcement proof |
| Funding | Test A$25,000; target around A$35,000 if base economics hold | Replace estimates with quotes and weekly cash plan |

These are assumptions, not approvals to spend or assertions that supply is secured.

## 2. Evidence and the supplier opportunity

German Butchery publicly offers wholesale supply from its Camellia factory and has its own consumer retail presence. This creates a plausible supplier relationship and a direct alternative for our customers. Its public website does not establish a wholesale price agreement, dropshipping service, stock API or permission to use its assets. [Supplier website](https://www.german-butchery.com.au/)

Selected public retail references checked on 15 September 2026:

| Product | Listed retail pack | Public price |
|---|---|---:|
| Continental Frankfurter | 5 sausages | A$7.90 |
| German Bratwurst | 3 sausages | A$8.50 |
| Nürnberger Bratwurst | 7 sausages | A$7.90 |
| Cheese Kransky | 3 sausages | A$8.50 |
| Jalapeño Cheese Kransky | 3 sausages | A$8.50 |

These are consumer reference prices, not our costs. Pack weights, ingredients, storage conditions and available wholesale formats must be obtained directly. Several party packs require advance ordering. [German Butchery click-and-collect catalogue](https://www.german-butchery.com.au/shop/)

### Supplier agreement requirements

The founder should obtain a written response covering:

1. Wholesale price list, minimums, case sizes, lead times, payment terms, inbound transport and price-change notice.
2. Permission to resell online and describe the relationship, plus approved product names, photography and claims.
3. Whether they can supply sealed retail packs, assemble our boxes, store finished boxes or dispatch to households. None is assumed.
4. Minimum remaining shelf life on receipt, chilled/frozen status, manufacturing and use-by dates, storage and cooking instructions.
5. Ingredient, allergen, nutrition and country-of-origin data for every SKU, including notification of recipe changes.
6. Lot identification, recall contacts, stock availability, shortage notice and approved alternatives.
7. Responsibility for quality failures, handling failures, credits, product liability and recalls.
8. Capacity at 25, 100 and 250 boxes per week and seasonal demand limits.

**Negotiating position:** Wiener Box brings repeat demand, scheduled orders, paid customer acquisition and gifting. Seek predictable allocation and useful unit costs before seeking exclusivity. Hold a backup supplier shortlist, but disclose any future sourcing changes and revalidate all product information.

### Supplier enquiry draft

> We are developing Wiener Box, a Sydney-focused online sausage subscription and gifting business. We would like to explore a wholesale relationship for sealed retail packs, starting with a small paid pilot. Could you share your wholesale range, minimum orders, lead times, pack specifications, shelf-life commitments and delivery arrangements? We would also like to discuss whether box assembly or household dispatch is possible, and permission to use approved product information and identify you as our supplier. Our initial planning range is 25–50 boxes per delivery cycle, subject to demand validation. We can provide proposed contents and a twelve-week forecast for discussion.

This is a prepared draft; it has not been sent.

## 3. Customers, competition and demand validation

### Priority customers

| Customer | Buying occasion | Main barrier | What earns the sale |
|---|---|---|---|
| Sydney BBQ host | Weekend gathering or easy dinner | Cost versus supermarket sausages | Distinctive selection, clear quantity and serving ideas |
| Gift buyer | Birthday, thank-you or housewarming | Will the recipient be home? | Reliable delivery window, message card and recipient coordination |
| German-food enthusiast | Familiar flavours and discovery | Authenticity and product detail | Accurate provenance and genuine supplier information |
| Small office buyer | Team lunch or staff gift | Logistics and invoice handling | Predictable packs, simple ordering and support |

The first two segments should drive the pilot. Office orders become a useful acquisition channel after delivery works reliably. Avoid positioning processed meat as a health product or promising that every sausage variety is German in origin.

### Competitive position

- **German Butchery direct:** strong product credibility and a price reference. Our offer needs useful curation, delivery and gifting beyond access to the same products.
- **Broad meat subscriptions:** Our Cow markets recurring meat boxes with a wider protein range. Wiener Box should test a narrower discovery and gifting proposition instead of trying to replace the household's entire meat shop. [Our Cow](https://www.ourcow.com.au/)
- **Local butchers and supermarkets:** convenient alternatives that customers will mention in interviews. Treat our assumed advantage in playfulness and curation as a hypothesis.
- **Gift hampers:** compete for the same occasion and budget. Test whether an edible, useful BBQ gift beats novelty alone.

No market-size estimate is being presented as established demand. A reachable first business is hundreds of regular customers within a validated delivery area. The workbook's Month 12 expectation of about 335 subscribers is a planning target, not a forecast backed by sales history.

### Four validation steps

1. **15 interviews:** five BBQ buyers, five gift buyers, five specialty-food buyers. Show actual contents and delivered prices. Ask about their last relevant purchase, quantity consumed, freezer capacity and delivery availability.
2. **100 qualified postcode leads:** use a concept page with an honest launch status, proposed delivered price and separate marketing consent. Measure qualified enquiries and purchase intent, not followers.
3. **25–50 paid pilot orders:** only after supply, handling and delivery are ready. Fulfil real orders at intended prices. Record every minute, cost, missing item, complaint and repeat purchase.
4. **Two renewal opportunities:** measure paid renewal and usage feedback. Novelty-driven first purchases alone do not validate subscriptions.

Suggested pilot gates: at least A$25 contribution on the core subscription after fulfilment and loss allowance, at least 70% of the first cohort completing a second paid delivery within 60 days, less than 3% service/refund incidence, and no unresolved food-safety failures. These are management targets, not industry benchmarks. Small samples need customer interviews alongside the percentages.

## 4. Offer and merchandising

### Launch products

| Offer | Proposed price before delivery | Contents concept | Purpose |
|---|---:|---|---|
| **The Regular Wiener Box** | A$79 per calendar month | A fixed mix of sealed sausage packs, recipe card, playful sleeve | Main recurring offer |
| **The One-Night Stand** | A$85 one-off | Same core selection without renewal | Low-commitment trial; model separately before launch |
| **The Gift That Sizzles** | A$99 one-off | Sausage selection, pantry accompaniment, message card, gift sleeve | Gifting and referral |
| **Pick Your Links** | Pack prices to be costed | Individual sealed sausage packs | Repeat favourites and basket additions |

A$12 local delivery is a modelling assumption. Display the full delivered price after postcode selection and before payment. The workbook models subscription, gift and a A$65 average individual basket. The A$85 trial variant is proposed merchandising and has not been separately forecast.

The core box might contain two frankfurter packs, two bratwurst packs, one cheese kransky pack and one Nürnberger pack. The quoted wholesale bill of materials must determine whether this is good value at A$79. Do not advertise a final weight, serving count or product saving until supplier pack data supports it.

**Value test:** the illustrative six-pack mix totals A$49.20 at the listed direct retail pack prices, versus our proposed A$79 product price. That A$29.80 premium before delivery is substantial and must be tested. Compare exact contents and ask customers to pay the intended delivered price. If the premium is too high, increase genuine food value, reduce handling cost, adjust price or stop the offer. A funny carton cannot repair poor value. [Retail comparison](https://www.german-butchery.com.au/shop/)

### Merchandising rules

- Lead with the subscription but make one-off purchase a clear choice. Do not quietly preselect recurring payment.
- Show packs, total verified weight, ingredient/allergen information, price, next charge, delivery policy and cancellation cutoff together.
- Start with stable contents. Later discovery editions need advance disclosure, recipe versioning and affirmative approval for material or allergen changes.
- Sell sealed packs individually. Avoid loose weight adjustments and variable final charges at launch.
- Set an initial A$60 merchandise minimum for standalone chilled orders; test higher minimums if the average A$65 basket cannot support acquisition.
- Add pantry products to an existing chilled shipment where practical. Do not force separate postage for a cheap extra.
- Keep recipient gifts one-off. Add prepaid multi-delivery gifts only when scheduling, expiry and unfulfilled liability tracking are proven.
- Offer gift messages and coordinated delivery. Avoid surprise perishable deliveries without confirming availability.

## 5. Fulfilment and food operations

### Recommended operating model

Use supplier-sealed, correctly labelled packs. Arrange assembly and dispatch through the supplier if agreed, or an approved chilled fulfilment operator. Own the customer relationship and service recovery. A home kitchen or household fridge is not an assumed fulfilment facility.

The exact handling model changes the regulatory position. NSW distinguishes businesses processing meat from outlets that only sell prepackaged meat, and food businesses must be licensed or notified as applicable. Obtain a written classification for our actual premises, storage, packing and transport activities before trading. [Retail meat premises](https://www.foodauthority.nsw.gov.au/industry/meat/retail-meat-premises-butchers), [licensing and notifying](https://www.foodauthority.nsw.gov.au/help/licensing)

CHILL is a candidate to request a quote from because it describes refrigerated transport, cold storage and packing capabilities. Coverage, household delivery suitability, minimum volumes, rates and integrations require confirmation. Obtain a second local quote through the supplier or another chilled carrier. [CHILL services](https://chill.com.au/)

### Weekly operating cycle

| Stage | Owner | Required record |
|---|---|---|
| Forecast upcoming paid and expected renewals | Operations | Quantity by SKU, route and dispatch window |
| Confirm supplier and route capacity | Operations | Purchase order and carrier booking |
| Publish order cutoff and delivery window | Commerce manager | Customer-visible date in Australia/Sydney time |
| Receive stock | Fulfilment | Quantity, lot, use-by, condition and temperature record |
| Assemble and allocate | Fulfilment | Component lots linked to finished box and order |
| Release shipment | Operations | Payment confirmed, no holds, correct address, safe stock |
| Dispatch | Carrier | Handover time, tracking and temperature-control evidence |
| Confirm arrival and resolve exceptions | Support | Delivery evidence, refund/replacement and reason |
| Reconcile | Founder | Orders, fees, supplier costs, inventory, wastage and cash |

Plan around the carrier's actual timetable. A sample Monday cutoff and Thursday delivery is illustrative only. Recurring billing dates and fulfilment cutoffs must work with the chosen subscription app. Calendar-month subscriptions are not equivalent to every four weeks.

### Cold-chain controls

Use a validated chilled transport system maintaining cold food at 5°C or below, or a documented alternative shown to be safe. Frozen goods must remain frozen. FSANZ also requires protection against contamination and appropriate separation of raw and ready-to-eat food. [FSANZ transport guidance](https://www.foodstandards.gov.au/sites/default/files/2023-10/InfoBite%20-%20Transporting%20food%20safely.pdf)

Practical implementation: trial the exact box, coolant, load, route and likely delay conditions; record results with appropriate temperature logging; establish maximum transit and unattended-drop times; define rejection and disposal rules with the operator. Do not promise a universal shelf life or that an ice pack makes ordinary parcel shipping suitable.

Provide plain instructions for prompt refrigeration, inspecting damaged packs and contacting support. If food may have arrived unsafe, advise the customer not to consume it and arrange an appropriate remedy. Do not ask a customer to taste food to assess safety or return chilled goods through ordinary post. Returned food does not automatically re-enter saleable inventory.

### Inventory and recall

Track supplier lot, recipe version, expiry, quantity, location, quarantine and the orders receiving each lot. Allocate the earliest-expiring suitable stock first. Keep finished-box inventory separate from individual-pack inventory so a pack cannot be sold twice. Hold stock with insufficient remaining shelf life for its scheduled route.

A recall workflow must identify affected customers, stop sale, hold stock, record communications and reconcile affected quantities. Run a mock recall before launch. Nominate the founder as incident owner and an alternate who can halt dispatch.

## 6. Economics and funding

The companion workbook is editable. Its assumptions are neither supplier quotes nor evidence of willingness to pay. All figures below are rounded outputs from its initial inputs.

### Contribution per delivered order

Contribution means revenue excluding GST less product, packaging, pick/pack, delivery, payment fees and the loss/service allowance. It remains available to cover marketing, fixed overhead and owner labour.

| Per order | Subscription | Gift | Individual basket |
|---|---:|---:|---:|
| Product price paid | A$79.00 | A$99.00 | A$65.00 |
| Delivery paid | 12.00 | 12.00 | 12.00 |
| Revenue excluding assumed GST | 91.00 | 109.99 | 76.30 |
| Product cost | 31.00 | 42.00 | 29.00 |
| Packaging + pick/pack + delivery | 27.00 | 30.00 | 27.00 |
| Fees + loss/service allowance | 3.71 | 4.44 | 3.17 |
| **Contribution before acquisition** | **29.29** | **33.55** | **17.13** |
| **Contribution margin** | **32.2%** | **30.5%** | **22.4%** |

**Historical scenario:** the workbook and numerical outputs in this section still use the original Shopify assumption of 1.75% + A$0.30. The founder subsequently chose Laravel/Lunar and Stripe. These outputs are a baseline scenario, not an updated funding forecast. Reforecast payment fees, Stripe Billing charges, Cloud resources and Laravel implementation/maintenance costs using actual merchant terms and launch-date rates. [Stripe Australia pricing](https://stripe.com/au/pricing)

Taxable product and delivery proportions are editable placeholders. Sausage-only and mixed food/gift orders must be classified correctly. GST does not apply uniformly to all food, and delivery treatment depends on the supply. Obtain accountant confirmation per SKU and shipping arrangement. [ATO food classification](https://www.ato.gov.au/law/view/document?PiT=99991231235958&locid=%27GII%2FGSTIIFL1%2FNAT%2FATO%27), [ATO delivery treatment](https://www.ato.gov.au/law/view/document?LocID=%22GSD%2FGSTD20023%2FNAT%2FATO%2FftF1%22&PiT=20251218000001)

### What makes or breaks the model

- At a A$35 acquisition cost, the subscription needs roughly **1.2 paid deliveries** to recover acquisition alone. This excludes fixed costs and does not mean the first order is profitable.
- A one-off gift at A$35 acquisition cost is slightly negative after acquisition; an individual basket is about A$18 negative. Acquire those orders through cheaper organic/referral traffic, improve basket economics, or prove later repeat contribution.
- A A$5 increase in chilled freight reduces subscription contribution from A$29.29 to A$24.29.
- Buying the same contents at a product cost 20% higher reduces subscription contribution to A$23.09.
- Both changes together reduce it to A$18.09, about 19.9% of revenue. A A$55 CAC would then take about 3.0 paid deliveries to recover before overhead.
- At the base price and other costs, the subscription can spend about **A$32.99 on product** and still achieve a 30% contribution margin. This is a negotiation ceiling, not a reason to cheapen the box.

At an illustrative A$28 blended contribution and A$3,750 monthly overhead including owner labour, approximately **134 fulfilled orders a month** cover those fixed costs before acquisition. If acquiring 100 new customers at A$35 each, that requirement rises to approximately **259 orders**. Calculate this with actual order mix, not subscription price alone.

### Initial twelve-month model

Assumptions include new subscribers increasing from 10 to 65 per month, 8% monthly churn among opening subscribers, 10% skipped renewals, A$35 blended acquisition cost, A$1,250 fixed monthly overhead, and A$2,500 monthly owner-labour allowance from Month 4. New members pay for their first box in the joining month. The model uses expected fractional customer counts.

| Result | Model output |
|---|---:|
| First-year net revenue | A$230,630 |
| First-year operating result after owner allowance | **–A$6,660** |
| Closing subscribers in Month 12 | About 335 |
| Completed deliveries in Month 12 | About 458 |
| Month 12 result after owner allowance | About A$2,928 |
| First month positive after owner allowance | Month 9 |
| Prelaunch expense allowance | A$11,000 |
| Protected working-capital reserve | A$5,000 |
| Tested starting funding | A$25,000 |
| Largest operating funding shortfall | About A$4,003, in Month 8 |
| Implied minimum funding under these assumptions | About A$29,003 |

**Recommendation:** budget around A$35,000 for a founder-built pilot if quotes support the assumptions. This provides roughly A$6,000 beyond the modelled minimum, not a guarantee of adequate runway. With under A$15,000, start with small prepaid one-off delivery runs, simpler packaging and demand validation before committing to the full recurring operation. Reforecast lower owner drawings explicitly if that is necessary; do not hide labour to claim profitability.

The cash calculation is a simplified operating-headroom proxy. It reserves A$5,000 and assumes sales receipts and variable costs settle in the same month as delivery. It does not schedule GST remittance, growing inventory, payment holds, financing, income tax or capital expenditure. Build a weekly thirteen-week cash forecast once supplier terms and payout timing are known. Large prepaid gift sales create delivery obligations rather than free spending money.

## 7. Brand, acquisition and retention

### Brand idea

Use an original rubber-hose sausage mascot, expressive gloves and shoes, heavy outlines and warm print texture. Mustard yellow, red and near-black are the main colours, with cream for reading surfaces. Product photography establishes appetite and portion truth; cartoons create recognition and gifting appeal. See the separate brand direction and concept artwork.

Use the confirmed spelling **Wiener Box** throughout the brand. Confirm name, domain, handles and trademark availability before investing in packaging. Search registered and pending marks and commission advice on confusingly similar names; no clearance is claimed. [IP Australia search guidance](https://www.ipaustralia.gov.au/trade-marks/search-existing-trade-marks)

### Channel priorities

1. **Instagram:** recipes, box reveals, gift moments and customer BBQs. Make the delivered price and service area easy to find.
2. **TikTok:** inexpensive native-style cooking and character comedy. Repurpose strong footage with a platform-appropriate edit.
3. **Email:** welcome education, useful cooking guidance, replenishment and seasonal gifts. Keep delivery and billing messages distinct from marketing.
4. **Local creators and partners:** Sydney food creators, BBQ communities and workplace organisers. Pay for useful content and relevant reach, with clear sponsorship disclosure and agreed reuse rights.
5. **Search:** useful product and cooking pages plus small, tightly targeted campaigns only when conversion and contribution are measurable.

Defer large awareness buys, broad national targeting, complex loyalty points and expensive influencer retainers. A small geographic audience and strong retention are enough to test the concept.

### Four-week content plan

| Week | Short video | Useful/carousel post | Community or gift post | Call to action |
|---|---|---|---|---|
| 1: Meet the box | Mascot introduces the real contents | How many packs are in the proposed box? | Founder explains the supplier relationship accurately | Join the local launch list |
| 2: Earn appetite | Bratwurst cooking demo | Three serving ideas and verified storage advice | Ask followers about their ideal BBQ | View contents and delivered price |
| 3: Make gifting easy | Open a gift box and read the card | How chilled gift delivery works | Birthday gift scenario with permissioned participants | Choose a delivery window |
| 4: Build repeat value | Two ways to use the same pack | How skip and cancellation work | First customers' honest feedback | Try a box or choose monthly |

Working rhythm: three short videos and one useful carousel each week, stories on three to five days, one batch filming session, and one genuinely useful weekly email to opted-in subscribers. Founder/support should answer questions daily on trading days. Publish real feedback with permission, including criticism that helps improve the offer.

### Pilot acquisition budget

Start with **A$1,500 over four weeks**, within the acquisition budget rather than added on top: A$700 local paid creative tests, A$400 creator samples and content, A$250 tasting/referral activation and A$150 adaptation/editing. Include the landed cost of gifted boxes. This budget buys a test, not a promised number of sales.

At A$35 blended CAC, A$1,500 would need about 43 new paying customers to meet the target. If advertising spends A$105 on a creative without a purchase, review or pause that test rather than letting it run indefinitely. Do not make decisions on isolated impressions or a single order.

Track campaign, creative, postcode and first-order type. Deduplicate purchase events with an order ID and exclude refunds from net results. Compare platform-attributed revenue against actual paid orders. Use customer cohort contribution after 30, 60 and 90 days to decide whether to scale.

### Retention journeys

- **Before first delivery:** accurate delivery window, storage expectations and what to do if the customer will be away.
- **After delivery:** useful preparation ideas and an easy route to report a problem.
- **Before renewal:** contents, total charge, charge date and the last time to skip/change.
- **After repeat delivery:** ask what was eaten and whether the quantity/frequency fits.
- **Cancellation:** immediate, clear confirmation; optional reason after the cancellation is complete.
- **Win-back:** relevant, consented message later, without automatic reactivation.
- **Referral:** small credit after the referred customer's paid fulfilment and refund window, with abuse controls and a margin cap.

Permission, sender identification and unsubscribe handling must meet Australia's spam rules. Do not treat a gift recipient's address as marketing consent. [ACMA guidance](https://www.acma.gov.au/avoid-sending-spam)

## 8. Customer service, administration and governance

Lunar now provides the core commerce admin in Laravel. The next custom admin modules add the dispatch board, purchase requirements, lots/expiry, packing manifests, service cases and profit by order. Avoid building a second payment ledger.

Suggested roles: founder/owner, fulfilment operator, support agent and accountant. Fulfilment staff see packing and delivery details; financial access is restricted. Require individual staff logins, multifactor authentication, role permissions and an audit trail for inventory changes, refunds and subscription changes.

Daily view: today's deliveries, unfulfilled paid orders, shortages, held/expired stock, failed payments, delivery exceptions and webhook failures. Weekly view: fulfilled revenue, contribution, CAC, repeat orders, churn, waste and next four weeks' committed stock needs. Monthly view: cash, inventory value, supplier performance and cohort contribution.

Publish terms, privacy, delivery conditions, subscription rules, returns/remedies, allergens and contact details before selling. Australian consumer guarantees cannot be replaced with a blanket “no refunds on food” policy. [ACCC consumer guarantees](https://www.accc.gov.au/consumers/buying-products-and-services/consumer-rights-and-guarantees)

Have the checkout and cancellation wording reviewed for the actual offer. The ACCC's action concerning alleged HelloFresh/Youfoodz subscription traps is directly relevant to clear enrolment and cancellation design; allegations are not findings. [ACCC subscription case](https://www.accc.gov.au/media-release/hellofresh-and-youfoodz-in-court-over-alleged-subscription-traps), [ACCC contracts](https://www.accc.gov.au/consumers/buying-products-and-services/contracts)

Verify food labels and online information against current supplier specifications and plain-English allergen requirements. Maintain a record of who approved each product version. Do not infer “gluten free,” “allergen free,” or health claims from a product name. [FSANZ allergen labelling](https://www.foodstandards.gov.au/consumer/labelling/allergen-labelling)

Collect only needed customer and delivery information. Assess Privacy Act coverage, including small-business exceptions, and publish accurate handling and retention practices. Keep payment-card data with the payment provider. [OAIC small-business guidance](https://www.oaic.gov.au/privacy/privacy-guidance-for-organisations-and-government-agencies/organisations/small-business)

## 9. Launch roadmap and decision gates

Indicative **8–12 weeks**, dependent on founder time, supplier response and fulfilment readiness. These are work packages, not promised dates.

| Stage | Deliverable | Gate to continue |
|---|---|---|
| Weeks 1–2 | Supplier quote, interviews, initial range costings, name checks, handling model | Credible food value and at least A$25 core contribution |
| Weeks 2–3 | Cold-chain trials and Lunar/Stripe purchase and renewal proof | Safe lanes, enforceable service area, successful recurring checkout/account tests |
| Weeks 3–5 | Brand refinement, real photography, product data, storefront and basic admin | Usable mobile guest, gift and subscription journeys |
| Weeks 5–7 | Carrier process, communications, inventory/lot capture, payment and exception testing | End-to-end rehearsal and successful mock recall |
| Weeks 7–9 | Capped 25–50-order paid pilot | Correct deliveries, measured cost and customer feedback |
| Weeks 9–12 | Renewal observation, improved offer, controlled acquisition | Repeat demand and contribution justify the next cohort |

If recurring-order integration is not ready, cap the first paid pilot at one-off boxes while completing the subscription workflows in the technical blueprint. If economics fail, change contents, price, delivery footprint or fulfilment. Additional software features are not the remedy for negative delivered contribution.

## 10. Risks and owner actions

| Risk | Early signal | Response | Owner |
|---|---|---|---|
| Wholesale arrangement unavailable | No written rates or allocation | Rework supply before taking orders | Founder |
| Food value does not justify price | Strong interest, weak paid conversion | Test contents and delivered price | Founder |
| Delivery cost too high | Quotes exceed A$17 assumption | Restrict routes, improve density, reprice | Operations |
| Cold-chain failure | Temperature excursion or damaged packs | Stop affected dispatch, quarantine, remedy and investigate | Incident owner |
| Novelty wears off | First order strong, second delivery weak | Change quantity/frequency and useful content | Product/marketing |
| Overselling components | Singles and boxes share the same physical stock twice | Separate allocations and reconcile daily | Operations/engineering |
| Subscription mismatch | Charges occur after skip or before supply is secured | Halt affected billing flow and fix source-of-truth integration | Engineering |
| Cash gap | Supplier invoice due before payout | Weekly cash forecast and protected reserve | Founder/accountant |
| Seasonal capacity | Promotional demand exceeds handling slots | Cap sales by dispatch capacity | Operations |
| Data/admin failure | Shared accounts or unprocessed integration events | MFA, permissions, alerts and recovery drills | Engineering |

### First actions

1. Obtain the supplier's wholesale pack and cost data using the prepared enquiry.
2. Request two chilled fulfilment quotes for the same pilot postcodes and box dimensions.
3. Validate the proposed A$91 delivered subscription price with target customers.
4. Replace cost assumptions and resolve the funding shortfall before committing launch spend.
5. Run the commerce compatibility spike described in the blueprint, then implement the storefront and admin in milestones.

## Research basis

Linked sources were checked on 15 September 2026. Public product prices and service features can change. Recommendations, proposed prices, operational targets, development estimates and forecast inputs are the plan's assumptions. Supplier permission, wholesale terms, name availability, regulatory classification and carrier service are unresolved until verified for this business.
