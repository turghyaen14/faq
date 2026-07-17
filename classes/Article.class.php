<?php
// FRONTEND-OWNED STUB. Backend fills the real queries inside each method body
// (marked BACKEND below) — signatures and return shapes must not change.
// See docs/DATA_CONTRACT.md Section B for the contract.
class Article
{

    function __construct()
    {
        global $conn;
        $this->conn = $conn;
        global $db_8_np2u;
        $this->db_8_np2u = $db_8_np2u;
    }

    // Applies the same filter options both getCards and getTotalCards accept
    // (search, company_id) so the two can never drift apart on what counts as
    // a match.
    private function filterCards($options = [])
    {
        $cards = DummyData::articleCards();

        if (!empty($options['company_id'])) {
            $company_id = intval($options['company_id']);
            $cards = array_values(array_filter($cards, function ($card) use ($company_id) {
                return intval($card['company_id']) === $company_id;
            }));
        }

        if (!empty($options['search'])) {
            $search = mb_strtolower(trim($options['search']));
            $cards = array_values(array_filter($cards, function ($card) use ($search) {
                return strpos(mb_strtolower($card['title']), $search) !== false
                    || strpos(mb_strtolower($card['excerpt']), $search) !== false;
            }));
        }

        return $cards;
    }

    function getCards($options = [])
    {
        global $USE_DUMMY_DATA;
        if ($USE_DUMMY_DATA) {
            $cards = $this->filterCards($options);
            $limit = isset($options['limit']) ? intval($options['limit']) : 0;
            $page = isset($options['page']) ? intval($options['page']) : 1;
            if ($page < 1) {
                $page = 1;
            }
            if ($limit > 0) {
                $start = ($page - 1) * $limit;
                $cards = array_slice($cards, $start, $limit);
            }
            return $cards;
        }
        // BACKEND: real query here. $options may include limit, page, search, category, company_id.
        // Must return an array of articleCard (docs/DATA_CONTRACT.md Section A2).
        return [];
    }

    function getTotalCards($options = [])
    {
        global $USE_DUMMY_DATA;
        if ($USE_DUMMY_DATA) {
            return count($this->filterCards($options));
        }
        // BACKEND: real query here (COUNT), same filters as getCards minus limit/page.
        return 0;
    }

    function getFeatured()
    {
        global $USE_DUMMY_DATA;
        if ($USE_DUMMY_DATA) {
            return DummyData::featured();
        }
        // BACKEND: real query here. Must return one featured (Section A3).
        return [];
    }

    function getDetailByFaqId($faq_id)
    {
        global $USE_DUMMY_DATA;
        if ($USE_DUMMY_DATA) {
            return DummyData::articleDetail();
        }
        // BACKEND: real query here. Should reuse Faq::getFaqDetailsByID,
        // Company::getCompanyDetails, and Faq::getFaqDetailsList (related_faqs)
        // rather than duplicating those queries. Must return one
        // articleDetail (Section A4).
        return [];
    }
}
?>
