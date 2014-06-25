//
//  WaitView.m
//  Zhouyu
//
//  Created by mac on 12-8-22.
//  Copyright (c) 2013年 Zhouyu All rights reserved.
//

#import "WaitView.h"

@implementation WaitView

@synthesize parentView, message;


- (id)initWithParentView:(UIView *)aParentView
{
    self = [super init];
    if(self)
    {
        self.message = NSLocalizedString(@"Loading...", nil);
        self.parentView = aParentView;
        [self createView];
        
        [self setFrame:CGRectMake((aParentView.bounds.size.width - self.frame.size.width) / 2, (aParentView.bounds.size.height - self.frame.size.height) / 2, self.frame.size.width, self.frame.size.height)];
        [aParentView addSubview:self];
        [self hide];
    }
    return self;
}

//显示
- (void)show
{
    [self setHidden:NO];
    [parentView bringSubviewToFront:self];
}

//隐藏
- (void)hide
{
    [self setHidden:YES];
}

- (void) createView
{
    UIImageView *bgView = [[UIImageView alloc] initWithImage:[UIImage imageNamed:@"WaitBGGray"]];
    
    CGRect rect = CGRectMake(0, 0,100,83);
    
    //UIView *bgView = [[UIView alloc]initWithFrame:rect];
    //bgView.backgroundColor = [UIColor];
    
    [bgView setFrame:rect];
    [self addSubview:bgView];
    
    self.bounds = rect;
    
    indicatorView = [[[UIActivityIndicatorView alloc] initWithFrame:CGRectMake(0, 0, 20, 20)]autorelease];
    [indicatorView setCenter:CGPointMake(bgView.bounds.size.width / 2, 30)];
    [indicatorView setActivityIndicatorViewStyle:UIActivityIndicatorViewStyleWhite];
    [self addSubview:indicatorView];
    [indicatorView startAnimating];
    
    UILabel *waitLabel = [[UILabel alloc] initWithFrame:CGRectMake(0, 50, bgView.frame.size.width, 14)];
    [bgView release];
    
    [waitLabel setText:self.message];
    waitLabel.backgroundColor = [UIColor clearColor];
    waitLabel.textAlignment = NSTextAlignmentCenter;
    waitLabel.font = [UIFont systemFontOfSize:12];
    waitLabel.textColor = [UIColor whiteColor];
    [self addSubview:waitLabel];
    [waitLabel release];
}

@end