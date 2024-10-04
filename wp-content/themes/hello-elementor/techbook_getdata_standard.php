<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'TECBOOK_STANDARDS_TABLE', $wpdb->prefix . 'tecbook_standards' );

// Hàm lấy tất cả dữ liệu từ bảng standards
function get_all_standards() {
    global $wpdb;
    $table_name = TECBOOK_STANDARDS_TABLE;
    $results = $wpdb->get_results( "SELECT * FROM $table_name" );
    return $results;
}

// Hàm lấy một standard theo id
function get_standard_by_id( $standard_id ) {
    global $wpdb;
    $table_name = TECBOOK_STANDARDS_TABLE;
    $standard_id = intval( $standard_id );
    $query = $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $standard_id );
    $standard = $wpdb->get_row( $query );
    return $standard;
}

// Hàm chuẩn bị dữ liệu standard để hiển thị hoặc trả về
function prepare_standard_data( $standard ) {
    if ( $standard ) {
        $data = array(
            'id'                        => intval( $standard->id ),
            'idStandard'                => ! empty( $standard->idStandard ) ? $standard->idStandard : '',
            'referenceNumber'           => ! empty( $standard->referenceNumber ) ? $standard->referenceNumber : '',
            'standardTitle'             => ! empty( $standard->standardTitle ) ? $standard->standardTitle : '',
            'status'                    => ! empty( $standard->status ) ? $standard->status : '',
            'referencedStandards'       => ! empty( $standard->referencedStandards ) ? $standard->referencedStandards : '',
            'referencingStandards'      => ! empty( $standard->referencingStandards ) ? $standard->referencingStandards : '',
            'equivalentStandards'       => ! empty( $standard->equivalentStandards ) ? $standard->equivalentStandards : '',
            'replaceStandard'           => ! empty( $standard->replaceStandard ) ? $standard->replaceStandard : '',
            'replacedByStandard'        => ! empty( $standard->replacedByStandard ) ? $standard->replacedByStandard : '',
            'standardBy'                => ! empty( $standard->standardBy ) ? $standard->standardBy : '',
            'languages'                 => ! empty( $standard->languages ) ? $standard->languages : '',
            'fullDescription'           => ! empty( $standard->fullDescription ) ? $standard->fullDescription : '',
            'ebookPrice'                => ! empty( $standard->ebookPrice ) ? floatval( $standard->ebookPrice ) : 0,
            'printPrice'                => ! empty( $standard->printPrice ) ? floatval( $standard->printPrice ) : 0,
            'bothPrice'                 => ! empty( $standard->bothPrice ) ? floatval( $standard->bothPrice ) : 0,
            'currency'                  => ! empty( $standard->currency ) ? $standard->currency : '',
            'historicalEditions'        => ! empty( $standard->historicalEditions ) ? $standard->historicalEditions : '',
            'documentHistoryStandardId' => ! empty( $standard->documentHistoryStandardId ) ? $standard->documentHistoryStandardId : '',
            'icsCode'                   => ! empty( $standard->icsCode ) ? $standard->icsCode : '',
            'keyword'                   => ! empty( $standard->keyword ) ? $standard->keyword : '',
            'identicalStandards'        => ! empty( $standard->identicalStandards ) ? $standard->identicalStandards : '',
            'publishedDate'             => ! empty( $standard->publishedDate ) ? date( 'Y-m-d', strtotime( $standard->publishedDate ) ) : '',
            'pages'                     => ! empty( $standard->pages ) ? intval( $standard->pages ) : 0,
            'byTechnology'              => ! empty( $standard->byTechnology ) ? $standard->byTechnology : '',
            'byIndustry'                => ! empty( $standard->byIndustry ) ? $standard->byIndustry : '',
            'previewPath'               => ! empty( $standard->previewPath ) ? $standard->previewPath : '',
            'coverPath'                 => ! empty( $standard->coverPath ) ? $standard->coverPath : '',
            'fullPath'                  => ! empty( $standard->fullPath ) ? $standard->fullPath : '',
        );
    } else {
        // Giá trị mặc định khi không tìm thấy standard
        $data = array(
            'id'                        => 0,
            'idStandard'                => '',
            'referenceNumber'           => '',
            'standardTitle'             => '',
            'status'                    => '',
            'referencedStandards'       => '',
            'referencingStandards'      => '',
            'equivalentStandards'       => '',
            'replaceStandard'           => '',
            'replacedByStandard'        => '',
            'standardBy'                => '',
            'languages'                 => '',
            'fullDescription'           => '',
            'ebookPrice'                => 0,
            'printPrice'                => 0,
            'bothPrice'                 => 0,
            'currency'                  => '',
            'historicalEditions'        => '',
            'documentHistoryStandardId' => '',
            'icsCode'                   => '',
            'keyword'                   => '',
            'identicalStandards'        => '',
            'publishedDate'             => '',
            'pages'                     => 0,
            'byTechnology'              => '',
            'byIndustry'                => '',
            'previewPath'               => '',
            'coverPath'                 => '',
            'fullPath'                  => '',
        );
    }

    return $data;
}
