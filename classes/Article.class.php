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

    function getCards($options = [])
    {
        global $USE_DUMMY_DATA;
        if ($USE_DUMMY_DATA) {
            $cards = DummyData::articleCards();
            $limit = isset($options['limit']) ? intval($options['limit']) : 0;
            if ($limit > 0) {
                $cards = array_slice($cards, 0, $limit);
            }
            return $cards;
        }
        // BACKEND: real query here. $options may include limit, page, search, category, company_id.
        // Must return an array of articleCard (docs/DATA_CONTRACT.md Section A2).
        return [];
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
