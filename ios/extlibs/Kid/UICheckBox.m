//
//  UICheckBox.m
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-9-24.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import "UICheckBox.h"

@implementation UICheckBox
//@synthesize onImg, offImg;
@synthesize myDelegate, isSelect, checkLabel, labelOnColor, labelOffColor;
- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        // Initialization code
    }
    return self;
}

- (id)initWithOnFile:(NSString *) onFileName OffFile:(NSString *) offFileName labelStr:(NSString *)labelString isSelect:(BOOL) tf callBack:(id<UICheckBoxDelegate>) delegate
{
    self = [super init];
    if(self)
    {
        [self initViewCheckOnFile:onFileName CheckOffFile:offFileName];
        [self initCheckBoxLabel:labelString];
        [self setCheckBoxIsSelected:tf];
        if(delegate)
        {
            self.myDelegate = delegate;
        }
        
    }
    return self;
}

- (id)initWithOnFile:(NSString *) onFileName OffFile:(NSString *) offFileName
{
    self = [super init];
    if(self)
    {
        [self initViewCheckOnFile:onFileName CheckOffFile:offFileName];
    }
    return self;
}

- (id)initWithOnFile:(NSString *) onFileName OffFile:(NSString *) offFileName labelStr:(NSString *)labelString onColor:(int)oncolorint offColor:(int)offcolorint;
{
    self = [super init];
    if(self)
    {
        self.labelOnColor = oncolorint;
        self.labelOffColor = offcolorint;
        [self initViewCheckOnFile:onFileName CheckOffFile:offFileName];
        [self initCheckBoxLabel:labelString];
    }
    return self;
}

- (id)initWithOnFile:(NSString *) onFileName OffFile:(NSString *) offFileName isSelect:(BOOL) tf callBack:(id<UICheckBoxDelegate>) delegate
{
    self = [super init];
    if(self)
    {
        [self initViewCheckOnFile:onFileName CheckOffFile:offFileName];
        if(delegate)
        {
            self.myDelegate = delegate;
        }
    }
    return self;
}

- (void) initViewCheckOnFile:(NSString *) checkOnFile CheckOffFile:(NSString *) checkOffFile
{
    UIImage *onImage = [UIImage imageNamed:checkOnFile];
    UIImage *offImage = [UIImage imageNamed:checkOffFile];
    [self initViewCheckOnImg:onImage CheckOffImg:offImage];
}

- (id)initWithCheckOnImg:(UIImage *) checkOnImg CheckOFFImg:(UIImage *) checkOFFImg
{
    self = [super init];
    if (self)
    {
        [self initViewCheckOnImg:checkOnImg CheckOffImg:checkOFFImg];
    }
    return self;
}

- (void) initViewCheckOnImg:(UIImage *) checkOnImg CheckOffImg:(UIImage *) checkOffImg
{
    CGRect frame = CGRectMake(0, 0, checkOnImg.size.width, checkOnImg.size.height);
    [self setFrame:frame];
    [self setImage:checkOffImg forState:UIControlStateNormal];
    [self setImage:checkOnImg forState:UIControlStateSelected];
    [self addTarget:self action:@selector(handleButtonTap:) forControlEvents:UIControlEventTouchUpInside];
}

- (void) initCheckBoxLabel:(NSString *) lableString
{
    /*
     UILabel *tmpTitleLabel = [[UILabel alloc] initWithFrame:CGRectMake(229, 70, 551, 46)];
     [tmpTitleLabel setText:@"Friends"];
     tmpTitleLabel.textColor = [UIColor whiteColor];
     tmpTitleLabel.font = [UIFont boldSystemFontOfSize:30];
     tmpTitleLabel.textAlignment = UITextAlignmentCenter;
     [[[CCDirector sharedDirector] view] addSubview:tmpTitleLabel];
     self.titleLabel = tmpTitleLabel;
     [tmpTitleLabel release];
     */
    self.checkLabel = [[[UILabel alloc] initWithFrame:CGRectMake(0, 0, self.bounds.size.width, self.bounds.size.height)] autorelease];
    [self.checkLabel setText:lableString];
    //self.checkLabel.textColor = [UIColor whiteColor];
    [self setLabelAlignment:UITextAlignmentCenter];
    //self.checkLabel.font = [UIFont systemFontOfSize:24];
    [self addSubview:self.checkLabel];
}

- (void) setLabelStyle:(UIFont *)setfont Color:(UIColor *) setcolor alignment:(NSTextAlignment) textAlgnment
{
    [self setLabelFont:setfont];
    [self setLabelColor:setcolor];
    [self setLabelAlignment:textAlgnment];
}

- (void) setLabelColorByIsSelect:(BOOL)isSelectBool
{
    if(isSelectBool)
    {
        //self setLabelColor:[UIColor co]
    }
}

- (void) setLabelFont:(UIFont *)setfont
{
    self.checkLabel.font = setfont;
}

- (void) setLabelColor:(UIColor *)setcolor
{
    self.checkLabel.textColor = setcolor;
}

- (void) setLabelAlignment:(NSTextAlignment) textAlgnment
{
    self.checkLabel.textAlignment = textAlgnment;
}

//checkbox选中事件
-(void)handleButtonTap:(id)sender
{
	//NSLog(@"==in handleButtonTap==");
    [self setCheckBoxIsSelected:!self.selected];
	if(self.myDelegate)
    {
        //[self.myDelegate didCheckBoxValeuChange:self isChecked:self.selected];
        [self.myDelegate didCheckBoxValeuChange:self isChecked:self.isSelect];
    }
    
}

- (void) setCheckBoxIsSelected:(BOOL)tf
{
    //NSLog(@"setCheckBoxIsSelected: %d", tf);
    self.isSelect = tf;
    [self setSelected:tf];
    
    UIColor *onColor = [UIColorFormat getUIColorByHEX:self.labelOnColor];
    UIColor *offColor = [UIColorFormat getUIColorByHEX:self.labelOffColor];
    if(tf)
    {
        [self setLabelColor:onColor];
    }
    else
    {
        [self setLabelColor:offColor];
    }
    /*
    if(tf)
    {
		[self setSelected:NO];
        NSLog(@"self setSelected:NO: %d", tf);
	}
    else
    {
		[self setSelected:YES];
        NSLog(@"self setSelected:YES: %d", tf);
	}
     */
    //[self.myDelegate didCheckBoxValeuChange:self.selected];
    
}

-(void) addVelueChangeDelegate:(id<UICheckBoxDelegate>) delegate
{
    //[delegate didCheckBoxValeuChange:self.selected];
    self.myDelegate = delegate;
}


/*
// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect
{
    // Drawing code
}
*/

@end
