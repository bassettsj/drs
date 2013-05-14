<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:sdef="foo" xmlns:djatoka="foo" version="1.0">
    <xsl:output omit-xml-declaration="yes"/>
    <xsl:template match="media">
        <xsl:apply-templates select="sdef:image_thumbnail"/>
        <xsl:apply-templates select="sdef:image_lowres"/>
        <xsl:apply-templates select="sdef:image_highres"/>
        <xsl:apply-templates select="sdef:image_master"/>
        <xsl:apply-templates select="djatoka:jp2SDef"/>
	<xsl:apply-templates select="sdef:pdf"/>
	<xsl:apply-templates select="sdef:xml_xslt"/>
	<xsl:apply-templates select="sdef:xml_ead"/>
	<xsl:apply-templates select="sdef:msword"/>
	<xsl:apply-templates select="sdef:msexcel"/>
	<xsl:apply-templates select="sdef:mspowerpoint"/>
    </xsl:template>
    
    <xsl:template match="sdef:image_thumbnail">
        <xsl:variable name="pid" select="@pid"/>
        <xsl:apply-templates>
            <xsl:with-param name="pid" select="$pid"/>
        </xsl:apply-templates>
    </xsl:template>

<xsl:template match="sdef:msword">
<xsl:variable name="pid" select="@pid"/>
<xsl:apply-templates>
<xsl:with-param name="pid" select="$pid"/>
</xsl:apply-templates>
</xsl:template>

<xsl:template match="datastream[@id='MSWORD']">
<xsl:param name="pid"/>
<li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/datastreams/MSWORD/content">Download Word Document</a></li>
</xsl:template>

<xsl:template match="sdef:msexcel">
<xsl:variable name="pid" select="@pid"/>
<xsl:apply-templates>
<xsl:with-param name="pid" select="$pid"/>
</xsl:apply-templates>
</xsl:template>

<xsl:template match="datastream[@id='MSEXCEL']">
<xsl:param name="pid"/>
<li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/datastreams/MSEXCEL/content">Download Excel Spreadsheet</a></li>
</xsl:template>

<xsl:template match="sdef:mspowerpoint">
<xsl:variable name="pid" select="@pid"/>
<xsl:apply-templates>
<xsl:with-param name="pid" select="$pid"/>
</xsl:apply-templates>
</xsl:template>

<xsl:template match="datastream[@id='MSPOWERPOINT']">
<xsl:param name="pid"/>
<li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/datastreams/MSPOWERPOINT/content">Download PowerPoint Presentation</a></li>
</xsl:template>





    
    <xsl:template match="sdef:image_highres">
        <xsl:variable name="pid" select="@pid"/>
        <xsl:apply-templates>
            <xsl:with-param name="pid" select="$pid"/>
        </xsl:apply-templates>
    </xsl:template>
    
    <xsl:template match="sdef:image_lowres">
        <xsl:variable name="pid" select="@pid"/>
        <xsl:apply-templates>
            <xsl:with-param name="pid" select="$pid"/>
        </xsl:apply-templates>
    </xsl:template>
    
    <xsl:template match="sdef:image_master">
        <xsl:variable name="pid" select="@pid"/>
        <xsl:apply-templates>
            <xsl:with-param name="pid" select="$pid"/>
        </xsl:apply-templates>
    </xsl:template>

    <xsl:template match="djatoka:jp2SDef">
        <xsl:variable name="pid" select="@pid"/>
        <xsl:apply-templates>
            <xsl:with-param name="pid" select="$pid"/>
            <xsl:with-param name="sdef" select="name()"/>
        </xsl:apply-templates>
    </xsl:template>

	<xsl:template match="sdef:xml_xslt">
		<xsl:variable name="pid" select="@pid"/>
		<xsl:apply-templates>
			<xsl:with-param name="pid" select="$pid"/>
		</xsl:apply-templates>
	</xsl:template>

        <xsl:template match="sdef:xml_ead">
        <xsl:variable name="pid" select="@pid"/>
        <xsl:apply-templates>
        <xsl:with-param name="pid" select="$pid"/>
        <xsl:with-param name="sdef" select="name()"/>
        </xsl:apply-templates>
        </xsl:template>

    <xsl:template match="datastream[@id='THUMBNAIL']">
        <xsl:param name="pid"/>
        <li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/datastreams/THUMBNAIL/content">Download Thumbnail Image</a></li>
    </xsl:template>

    <xsl:template match="datastream[@id='LOWRES']">
        <xsl:param name="pid"/>
        <li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/datastreams/LOWRES/content">Download Low Resolution Image</a></li>
    </xsl:template>
    
    <xsl:template match="datastream[@id='HIGHRES']">
        <xsl:param name="pid"/>
        <li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/datastreams/HIGHRES/content">Download High Resolution Image</a></li>
    </xsl:template>
    
    <xsl:template match="datastream[@id='MASTER']">
        <xsl:param name="pid"/>
        <li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/datastreams/MASTER/content">Download Master Image</a></li>
    </xsl:template>
    
    <xsl:template match="method[@id='getImageView']">
        <xsl:param name="pid"/>
        <xsl:param name="sdef"/>
        <li><a href="http://libfedora.neu.edu:8080/fedora/objects/{$pid}/methods/{$sdef}/getImageView">View Pan and Zoom Image</a></li>
    </xsl:template>

	<xsl:template match="datastream[@id='XSLT']">
		<xsl:param name="pid"/>
		<li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/datastreams/XSLT/content">Download XSLT File</a></li>
	</xsl:template>
        <xsl:template match="datastream[@id='EAD']">
		<xsl:param name="pid"/>
		<li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/datastreams/EAD/content">Download EAD File</a></li>
	</xsl:template>

	<xsl:template match="method[@id='getHTML']">
		<xsl:param name="pid"/>
		<xsl:param name="sdef"/>
		<li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/methods/{$sdef}/getHTML">View Finding Aid</a></li>
	</xsl:template>



    <xsl:template match="sdef:pdf">
        <xsl:variable name="pid" select="@pid"/>
        <xsl:apply-templates>
            <xsl:with-param name="pid" select="$pid"/>
        </xsl:apply-templates>
    </xsl:template>

    <xsl:template match="datastream[@id='PDF']">
        <xsl:param name="pid"/>
        <li><a href="http://libfedora.neu.edu/fedora/objects/{$pid}/datastreams/PDF/content">Download PDF Document</a></li>
    </xsl:template>

    
    <xsl:template match="*"/> 
    
</xsl:stylesheet>
